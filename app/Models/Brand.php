<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'gym_id'
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

}
