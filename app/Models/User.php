<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gym_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function gym()
    {
        return $this->hasOne(Gym::class);
    }

        public function coach()
    {
        return $this->hasOne(Coach::class);
    }

    public function person()
    {
        return $this->hasOneThrough(
            Person::class, // Final
            Coach::class,  // Intermedio
            'user_id',    // FK en Coach que apunta a User
            'id',          // FK en Person
            'id',          // PK en User
            'person_id'   // FK en Coach que apunta a Person
        );
    }

    public function category_schedule()
    {
        return $this->hasMany(category_schedule::class, 'user_id');
    }
}
