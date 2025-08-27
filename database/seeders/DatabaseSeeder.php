<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Day;
use App\Models\Gym;
use App\Models\Status;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Alejandro Esteche',
            'email' => 'alejandrob12esteche@gmail.com',
            'password' => bcrypt('Lhumos1234')
        ]);

        //Dias de la semana
        $daysOfWeek = [
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado',
            'Domingo',
        ];

        foreach($daysOfWeek as $day){
            Day::factory()->create([
                'name' => $day,
            ]);
        }

        //Estados de Mensualidad
        $statuses = [
            'Al día',
            'Adeudando',
            'Cancelado',
        ];

        foreach($statuses as $status){
            Status::factory()->create([
                'name' => $status,
            ]);
        }

        
    }
}

