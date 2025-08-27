<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'is_active',
        'gym_id',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
