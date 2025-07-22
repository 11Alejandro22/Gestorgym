<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Coach;

class CoachRow extends Component
{
    public Coach $coach;

    public function toggle()
    {
        $this->coach->is_active = !$this->coach->is_active;
        $this->coach->save();
    }

    public function render()
    {
        return view('livewire.admin.coach-row');
    }
}
