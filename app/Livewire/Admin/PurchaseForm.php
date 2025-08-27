<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;

class PurchaseForm extends Component
{
    public $supplier_id = '';
    public $selectedProductId = '';
    public $price = 0;
    public $stock = 1;
    public $discount_percentage = 0;
    public $discount_amount = 0;

    public $selectedProducts = [];
    public $products = [];
    public $suppliers = [];

    public function mount()
    {
        $user = auth('web')->user();
        $this->products = Product::where('is_active', 1)
                            ->where('gym_id', $user->gym_id)
                            ->get();

        $this->suppliers = Supplier::where('is_active', 1)
                            ->where('gym_id', $user->gym_id)
                            ->get();
    }

    public function addProduct()
    {
        $this->validate([
            'selectedProductId' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:1',
            'supplier_id' => 'required|exists:suppliers,id',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
        ]);

        if (!empty($this->selectedProducts) && $this->supplier_id !== $this->selectedProducts[0]['supplier_id']) {
            $this->addError('supplier_id', 'No se puede cambiar de proveedor una vez agregado un producto.');
            return;
        }

        $user = auth('web')->user();
        $product = Product::with(['brand', 'productType'])
            ->where('id', $this->selectedProductId)
            ->where('is_active', 1)
            ->where('gym_id', $user->gym_id)
            ->first();

        if (!$product) {
            $this->addError('selectedProductId', 'Producto no encontrado o inactivo.');
            return;
        }

        $subtotal = ($this->price * $this->stock) - $this->discount_amount;
        if ($this->discount_percentage > 0) {
            $subtotal -= ($subtotal * ($this->discount_percentage / 100));
        }

        $this->selectedProducts[] = [
            'id' => $product->id,
            'name' => $product->name,
            'brand' => $product->brand->name ?? 'Sin marca',
            'product_type' => $product->productType->name ?? 'Sin tipo',
            'price' => floatval($this->price),
            'quantity' => intval($this->stock),
            'discount_percentage' => floatval($this->discount_percentage),
            'discount_amount' => floatval($this->discount_amount),
            'subtotal' => $subtotal,
            'supplier_id' => $this->supplier_id,
        ];

        $this->reset(['selectedProductId', 'price', 'stock', 'discount_percentage', 'discount_amount']);
        $this->price = 0;
        $this->stock = 1;
    }

    public function removeProduct($index)
    {
        unset($this->selectedProducts[$index]);
        $this->selectedProducts = array_values($this->selectedProducts);
    }

    public function updateQuantity($index, $value)
    {
        $qty = max(1, intval($value));
        $this->selectedProducts[$index]['quantity'] = $qty;

        // recalculo subtotal (misma lógica)
        $price = floatval($this->selectedProducts[$index]['price'] ?? 0);
        $discA = floatval($this->selectedProducts[$index]['discount_amount'] ?? 0);
        $discP = floatval($this->selectedProducts[$index]['discount_percentage'] ?? 0);

        $subtotal = ($price * $qty) - $discA;
        if ($discP > 0) {
            $subtotal -= ($subtotal * ($discP / 100));
        }

        $this->selectedProducts[$index]['subtotal'] = round($subtotal, 2);
    }

    public function getTotalProperty()
    {
        return collect($this->selectedProducts)->sum('subtotal');
    }

    public function guardarCompra()
    {
    
        // Validar los datos usando reglas parecidas al store
        $this->validate([
            'supplier_id'           => 'required|exists:suppliers,id',
            'selectedProducts'      => 'required|array|min:1',
            'selectedProducts.*.id' => 'required|numeric|exists:products,id',
            'selectedProducts.*.quantity' => 'required|numeric|min:1',
            'selectedProducts.*.price' => 'required|numeric|min:0',
            'selectedProducts.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'selectedProducts.*.discount_amount' => 'nullable|numeric|min:0',
        ]);

        $user = auth('web')->user();

        // Obtener el próximo número de factura
        $lastInvoice = Purchase::where('gym_id', $user->gym_id)
            ->orderByDesc('invoice_number')
            ->first();

        $nextInvoiceNumber = $lastInvoice ? $lastInvoice->invoice_number + 1 : 1;

        DB::transaction(function () use ($user, $nextInvoiceNumber) {
            // Crear compra
            $purchase = Purchase::create([
                'supplier_id'    => $this->supplier_id,
                'purchase_date'  => now(),
                'invoice_number' => $nextInvoiceNumber,
                'invoice_type'   => 'A',
                'total'          => 0,  // se actualizará después
                'is_active'      => 1,
                'gym_id'         => auth('web')->user()->gym_id,
            ]);

            $details = [];

            foreach ($this->selectedProducts as $prod) {
                $qty = $prod['quantity'];
                $price = $prod['price'];
                $discP = $prod['discount_percentage'] ?? 0;
                $discA = $prod['discount_amount'] ?? 0;

                $subtotal = ($price * $qty) - $discA;
                if ($discP > 0) {
                    $subtotal -= ($subtotal * ($discP / 100));
                }

                $details[] = [
                    'purchase_id' => $purchase->id,
                    'product_id' => $prod['id'],
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'discount_percentage' => $discP,
                    'discount_amount' => $discA,
                    'subtotal' => $subtotal,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insertar detalles
            PurchaseDetail::insert($details);

            // Actualizar stock en masa
            $caseStatements = '';
            $ids = [];
            foreach ($details as $detail) {
                $caseStatements .= "WHEN {$detail['product_id']} THEN stock + {$detail['quantity']} ";
                $ids[] = $detail['product_id'];
            }
            $idsList = implode(',', $ids);

            DB::update("
                UPDATE products
                SET stock = CASE id
                    {$caseStatements}
                    ELSE stock
                END
                WHERE id IN ({$idsList})
            ");

            // Actualizar total compra
            $purchase->update(['total' => array_sum(array_column($details, 'subtotal'))]);
        });

        $this->reset(['selectedProducts', 'supplier_id']);

        session()->flash('swal', [
            'text'  => 'La compra se ha guardado correctamente.',
            'title' => '¡Bien hecho!',
            'icon'  => 'success',
        ]);

        return redirect()->route('admin.purchases.index');
    }

    public function render()
    {
        return view('livewire.admin.purchase-form');
    }
}