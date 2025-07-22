<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'due_date',
        'amount',
        'paid_date',
        'client_id',
        'status_id'
    ];

    // Relación: Una cuota pertenece a un cliente con una categoría/horario
    public function Client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // Relación: Una cuota puede tener muchos pagos
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
