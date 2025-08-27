<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_type;
use Livewire\Component;

class ManageProducts extends Component
{
    public $first_name = ''; // nombre del producto
    public $brand_id_select = '';
    public $product_type_id_select = '';
    public $is_active = '';

    public Product $product;

    public function toggle($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();
    }

    public function render()
    {
        $user = auth('web')->user();

        $brands = Brand::where('gym_id', $user->gym_id)
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->get();

        $product_types = Product_type::where('gym_id', $user->gym_id)
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->get();

        $query = Product::with(['brand', 'productType', 'gym'])
            ->where('gym_id', $user->gym_id)
            ->orderByDesc('id');

        if (!empty($this->first_name)) {
            $query->where('name', 'like', '%' . $this->first_name . '%');
        }

        if (!empty($this->brand_id_select)) {
            $query->where('brand_id', $this->brand_id_select);
        }

        if (!empty($this->product_type_id_select)) {
            $query->where('product_type_id', $this->product_type_id_select);
        }

        if ($this->is_active !== '') {
            $query->where('is_active', $this->is_active);
        }

        $products = $query->paginate(8);

        return view('livewire.admin.manage-products', [
            'products' => $products,
            'brands' => $brands,
            'product_types' => $product_types,
        ]);
    }

    
}
