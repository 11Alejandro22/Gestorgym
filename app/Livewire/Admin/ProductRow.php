<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\Product_type;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ProductRow extends Component
{
    public $first_name      = ''; // nombre del producto
    public $brand_id        = '';
    public $product_type_id = '';

    public function render()
    {
        $user = auth('web')->user();

        $brands = Brand::where('gym_id', $user->gym_id)
            ->where('is_active', 1)
            ->orderBy('id', 'desc')
            ->get();

        $product_types = Product_type::where('gym_id', $user->gym_id)
            ->where('is_active', 1)
            ->orderBy('id', 'desc')
            ->get();

        $query = DB::table('products')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('product_types', 'products.product_type_id', '=', 'product_types.id')
            ->join('gyms', 'products.gym_id', '=', 'gyms.id')
            ->where('products.gym_id', $user->gym_id)
            ->where('products.is_active', 1)
            ->select(
                'products.description as descripcion',
                'products.stock',
                'products.image',
                'products.price',
                'products.name as nombre_producto',
                'brands.name as marca',
                'product_types.name as tipo_producto',
                'gyms.name as gimnasio'
            );

        if ($this->first_name) {
            $query->where('products.name', 'like', '%' . $this->first_name . '%');
        }

        if ($this->brand_id) {
            $query->where('products.brand_id', $this->brand_id);
        }

        if ($this->product_type_id) {
            $query->where('products.product_type_id', $this->product_type_id);
        }

        $products = $query->get();

        return view('livewire.admin.product-row', [
            'products' => $products,
            'brands' => $brands,
            'product_types' => $product_types,
        ]);
    }
}
