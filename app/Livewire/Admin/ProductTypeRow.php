<?php

namespace App\Livewire\Admin;

use App\Models\Product_type;
use Livewire\Component;


class ProductTypeRow extends Component
{
    public Product_type $product_type;

    public function toggle()
    {
        $this->product_type->is_active = !$this->product_type->is_active;
        $this->product_type->save();
    }

    public function render()
    {
        return view('livewire.admin.product-type-row');
    }
}
