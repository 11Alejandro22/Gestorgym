<?php

namespace App\Livewire\Admin;
use Livewire\Component;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceForm extends Component
{
    public $quantity = 1;
    public $product = '';
    public $brand_id;
    public $brands = [];
    public $selectedProducts = [];
    public $total = 0;
    public $stockError = '';

    public function mount()
    {
        $user = auth('web')->user();
        $this->brands = Brand::where('is_active', 1)
                            ->where('gym_id', $user->gym_id)
                            ->get();
    }

    public function updatedProduct($value)
    {
        // Si el campo queda vacío, limpia el mensaje
        if (empty($value)) {
            $this->stockError = '';
        }
    }

    public function addProduct($productId)
    {
        $product = Product::with('brand', 'productType')->find($productId);

        if (!$product) {
            return;
        }

        // Validar que la cantidad sea numérica y mayor a 0
        if (!is_numeric($this->quantity) || (int)$this->quantity < 1) {
            $this->stockError = "Alerta: no puede dejar el campo de cantidad vacío o menor a 1.";
            return;
        }

        // Verificar stock
        if ($product->stock < $this->quantity) {
            $this->stockError = "Alerta: cantidad de stock insuficiente para {$product->name}. Disponible: {$product->stock}";
            return;
        }

        // Limpiar mensaje previo si todo está bien
        $this->stockError = '';

        // Agregar producto al array
        $this->selectedProducts[] = [
            'id' => $product->id,
            'name' => $product->name,
            'brand' => $product->brand->name ?? '',
            'product_type' => $product->productType->name ?? '',
            'price' => $product->price,
            'quantity' => (int)$this->quantity,
            'subtotal' => $product->price * (int)$this->quantity,
        ];

        $this->calcularTotal();
        $this->quantity = 1; // reset cantidad
    }

    public function updateQuantity($index, $newQuantity)
    {
        // Validar que sea numérico y mayor a 0
        if (!is_numeric($newQuantity) || (int)$newQuantity <= 0) {
            $this->stockError = "La cantidad debe ser un número mayor a 0.";
            return;
        }

        if (isset($this->selectedProducts[$index])) {
            $this->selectedProducts[$index]['quantity'] = (int) $newQuantity;
            $this->selectedProducts[$index]['subtotal'] =
                $this->selectedProducts[$index]['price'] * (int) $newQuantity;
        } else {
            $this->stockError = "Debe seleccionar al menos un producto.";
            return;
        }

        $this->stockError = null; // Limpia error si todo está bien
        $this->calcularTotal();
    }

    public function removeProduct($index)
    {
        unset($this->selectedProducts[$index]);
        $this->selectedProducts = array_values($this->selectedProducts); // reindexar
        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->total = collect($this->selectedProducts)->sum('subtotal');
    }

    public function guardarVenta()
    {
        $user = auth('web')->user();

        if (empty($this->selectedProducts)) {
            $this->stockError = "Debe seleccionar al menos un producto.";
            return;
        }
        // VALIDACIÓN BASE
        $this->validate([
            'selectedProducts' => 'required|array|min:1',
            'selectedProducts.*.id' => 'required|integer|exists:products,id',
            'selectedProducts.*.quantity' => 'required|integer|min:1',
        ]);


        // EVITAR DUPLICADOS
        $ids = array_column($this->selectedProducts, 'id');
        if (count($ids) !== count(array_unique($ids))) {
            session()->flash('error', 'No se pueden cargar productos duplicados.');
            return;
        }

        // VALIDAR STOCK DISPONIBLE
        foreach ($this->selectedProducts as $producto) {
            $productDB = Product::find($producto['id']);

            if ($productDB->stock < $producto['quantity']) {
                // En Livewire 3: evento de navegador
                session()->flash('swal', [
                    'title' => 'Oops...',
                    'text'  => "Stock insuficiente para {$productDB->name}. Disponible: {$productDB->stock}",
                    'icon'  => 'error',
                ]);
                return ;
            }
        }

        DB::beginTransaction();

        try {
            // OBTENER NÚMERO DE FACTURA
            $ultimoNumero = Invoice::where('gym_id', $user->gym_id)
                ->orderBy('id', 'desc')
                ->value('invoice_number') ?? 0;

            $nuevoNumero = $ultimoNumero + 1;

            // CREAR FACTURA
            $factura = Invoice::create([
                'invoice_number' => $nuevoNumero,
                'invoice_date'   => now(),
                'customer'       => 'Consumidor final',
                'total'          => 0,
                'gym_id'         => $user->gym_id,
            ]);

            $total = 0;

            // REGISTRAR DETALLES Y DESCONTAR STOCK
            foreach ($this->selectedProducts as $producto) {
                $subtotal = $producto['price'] * $producto['quantity'];
                $total += $subtotal;

                InvoiceDetail::create([
                    'invoice_id' => $factura->id,
                    'product_id' => $producto['id'],
                    'quantity'   => $producto['quantity'],
                    'price'      => $producto['price'],
                    'subtotal'   => $subtotal,
                ]);

                // Descontar del stock
                $productDB = Product::find($producto['id']);
                $productDB->decrement('stock', $producto['quantity']);
            }

            // ACTUALIZAR TOTAL EN FACTURA
            $factura->update(['total' => $total]);
            DB::commit();

            // RESETEAR CAMPOS
            $this->reset(['quantity', 'product', 'brand_id', 'selectedProducts', 'total']);

            // SWEETALERT
            session()->flash('swal', [
                'text'   => 'Venta Realizada correctamente.',
                'title'  => '¡Bien hecho!',
                'icon'   => 'success',
            ]);

            return redirect()->route('admin.invoices.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al guardar la venta: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $user = auth('web')->user();

        $products = collect(); // Por defecto vacío

        // Solo buscar si hay algo escrito en product o hay una marca seleccionada
        if (!empty($this->product) || !empty($this->brand_id)) {
            $query = Product::with('brand', 'productType')
                            ->where('is_active', 1)
                            ->where('gym_id', $user->gym_id);

            if (!empty($this->product)) {
                $query->where('name', 'like', '%' . $this->product . '%');
            }

            if (!empty($this->brand_id)) {
                $query->where('brand_id', $this->brand_id);
            }

            $products = $query->paginate(3);
        }

        return view('livewire.admin.invoice-form', [
            'products' => $products,
            'brands' => $this->brands,
        ]);
    }
}
