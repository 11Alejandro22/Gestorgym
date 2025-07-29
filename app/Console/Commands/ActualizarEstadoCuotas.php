<?php

namespace App\Console\Commands;

use App\Models\Installment;
use Illuminate\Console\Command;

class ActualizarEstadoCuotas extends Command
{
    protected $signature = 'cuotas:actualizar';

    protected $description = 'Actualiza el estado de las cuotas vencidas a adeudando.';

    public function handle()
    {
        $cantidad = Installment::where('status_id', '!=', 3)
            ->where('due_date', '<', now())
            ->update(['status_id' => 2]);

        $this->info("Se actualizaron $cantidad cuotas vencidas.");
    }
}
