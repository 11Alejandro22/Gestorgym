<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'person_id',
        'gym_id',
        'is_active'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function categorySchedules()
    {
        return $this->belongsToMany(category_schedule::class, 'category_schedule_clients', 'client_id', 'category_schedule_id')
                    ->withTimestamps();
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
