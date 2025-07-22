<?php

namespace App\Console\Commands;

use App\Models\Installment;
use Illuminate\Console\Command;

class ActualizarEstadoCuotas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cuotas:actualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Buscar cuotas vencidas y activas
        $cuotas = Installment::where('status_id', '!=', 3) // que no estén canceladas
            ->where('due_date', '<', now())
            ->get();

        foreach ($cuotas as $cuota) {
            $cuota->update(['status_id' => 2]); // 2 = adeudando
        }

        $this->info('Cuotas vencidas actualizadas correctamente.');
    }
}
