<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class category_schedule extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'day_id',
        'start_time',
        'end_time',
    ];
    

    // Schedule.php
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function days()
    {
        return $this->belongsToMany(Day::class, 'category_schedule_day');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'category_schedule_clients', 'category_schedule_id', 'client_id')
        ->withPivot('enrollment_date')            
        ->withTimestamps();
    }

    /**
     * Accessor para formatear start_time sin segundos.
     */
    protected function startTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i')
        );
    }

    /**
     * Accessor para formatear end_time sin segundos.
     */
    protected function endTime(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i')
        );
    }
}
