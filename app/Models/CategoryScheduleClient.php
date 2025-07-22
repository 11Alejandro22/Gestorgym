<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryScheduleClient extends Model
{
    protected $fillable = [
        'enrollment_date',
        'category_schedule_id',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function categorySchedule()
    {
        return $this->belongsTo(category_schedule::class);
    }

    
}
