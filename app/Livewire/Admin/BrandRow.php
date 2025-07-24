<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Brand;

class BrandRow extends Component
{

    public Brand $brand;

    public function toggle()
    {
        $this->brand->is_active = !$this->brand->is_active;
        $this->brand->save();
    }

    public function render()
    {
        return view('livewire.admin.brand-row');
    }
}
