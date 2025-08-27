<?php

namespace App\Livewire\Admin;

use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;

class PurchaseRow extends Component
{
    public $supplier_id     = '';
    public $purchase_date   = '';
    
    public function render()
    {
        $user = auth('web')->user();

        $suppliers = Supplier::where('gym_id', $user->gym_id)
        ->where('is_active', 1)
        ->get();


        $user = auth('web')->user();
        
        $query = Purchase::with('supplier', 'gym')
        ->where('gym_id', $user->gym_id)
        ->orderBy('id','desc');
        
        if ($this->supplier_id) {
            $query->where('supplier_id', $this->supplier_id);
        }
        
        if ($this->purchase_date !== '') {
            $query->where('purchase_date', $this->purchase_date);
        }
        
        $purchases = $query->paginate(10);
        
        return view('livewire.admin.purchase-row', compact('purchases', 'suppliers'));
    }
}
