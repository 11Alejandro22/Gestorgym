<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_type extends Model
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

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
