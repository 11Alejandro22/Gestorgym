<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Client;

class ClientsIndex extends Component
{
    public $first_name = '';
    public $last_name  = '';
    public $DNI        = '';
    public $is_active  = '';

    public function render()
    {
        $query = Client::with('person','installments.status');

        $query->whereHas('person', function ($q) {
            if ($this->first_name) {
                $q->where('first_name', 'like', '%' . $this->first_name . '%');
            }
            if ($this->last_name) {
                $q->where('last_name', 'like', '%' . $this->last_name . '%');
            }
            if ($this->DNI) {
                $q->where('DNI', 'like', '%' . $this->DNI . '%');
            }
        });

        if ($this->is_active !== '') {
            $query->where('is_active', $this->is_active);
        }

        return view('livewire.admin.clients-index', [
            'results' => $query->get(),
        ]);
    }


    public function toggleIsActive($clientId)
    {
        $client = Client::findOrFail($clientId);

        $client->is_active = !$client->is_active;
        $client->save();
    }
}


