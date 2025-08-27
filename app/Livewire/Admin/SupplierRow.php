<?php

namespace App\Livewire\Admin;

use App\Models\Supplier;
use Livewire\Component;

class SupplierRow extends Component
{
    
    public $name        = ''; // nombre del producto
    public $is_active   = '';
    
    public function render()
    {
        $user = auth('web')->user();
        
        $query = Supplier::where('gym_id', $user->gym_id)
        ->orderBy('id','desc');
        
        if ($this->name) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }
        
        if ($this->is_active !== '') {
            $query->where('is_active', $this->is_active);
        }
        
        $suppliers = $query->paginate(10);
        
        return view('livewire.admin.supplier-row', compact('suppliers'));
    }

    public Supplier $supplier;
    
    public function toggle($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->is_active = !$supplier->is_active;
        $supplier->save();
    }
}
