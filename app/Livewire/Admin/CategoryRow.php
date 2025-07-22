<?php


namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class CategoryRow extends Component
{
    public Category $category;

    public function toggle()
    {
        $this->category->is_active = !$this->category->is_active;
        $this->category->save();
    }

    public function render()
    {
        return view('livewire.admin.category-row');
    }
}
