<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Client;
use App\Models\Installment;
use Carbon\Carbon;

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

        // Cambiar estado del cliente
        $client->is_active = !$client->is_active;
        $client->save();

        // Obtener todas las cuotas asociadas
        $installments = Installment::where('client_id', $clientId)->get();

        foreach ($installments as $installment) {
            if ($client->is_active) {
                // Reactivar cliente -> status_id = 1 y due_date = hoy + 30 días
                $installment->status_id = 1;
                $installment->due_date = Carbon::now()->addDays(30);
            } else {
                // Desactivar cliente -> status_id = 3
                $installment->status_id = 3;
            }
            $installment->save();
        }
    }
}


