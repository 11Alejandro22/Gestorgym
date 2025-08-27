<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $fillable = [
        'user_id',
        'person_id',
        'photo_path',
        'is_active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($coach) {
            // Borra el usuario relacionado
            if ($coach->user) {
                $coach->user->delete();
            }

            // Borra la persona relacionada
            if ($coach->person) {
                $coach->person->delete();
            }

            // Si quieres asegurarte, puedes borrar category_schedules explícitamente
            if ($coach->user) {
                $coach->user->category_schedule()->delete();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
