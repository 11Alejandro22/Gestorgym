<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class HistorialPagos extends Component
{
    use WithPagination;

    public int $client_id;

    public function render()
    {
        $historial = DB::table('payments')
            ->join('payment_methods', 'payments.payment_method_id', '=', 'payment_methods.id')
            ->join('installments', 'payments.installment_id', '=', 'installments.id')
            ->join('clients', 'installments.client_id', '=', 'clients.id')
            ->join('persons', 'clients.person_id', '=', 'persons.id')
            ->where('clients.id', $this->client_id)
            ->select(
                'payments.payment_date',
                'payment_methods.name as metodo_pago',
                'payments.amount_paid',
                'persons.first_name',
                'persons.last_name'
            )
            ->orderByDesc('payments.payment_date')
            ->paginate(5);

        return view('livewire.historial-pagos', compact('historial'));
    }
}
