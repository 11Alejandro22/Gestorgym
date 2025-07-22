<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    /** @use HasFactory<\Database\Factories\DayFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function categorySchedules()
    {
        return $this->belongsToMany(category_schedule::class, 'category_schedule_day');
    }
}
