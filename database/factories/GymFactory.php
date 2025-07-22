<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Gym; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GymFactory extends Factory
{
    /**
     * Define the model's default state.
     *
    //  *@return array<string, mixed>
     */
    protected $model = Gym::class;
    
    public function definition(): array
    {
        $name = $this->faker->word;

        return [
            'name'      => $name,
            'slug'      => Str::slug($name),
            'address'   => $this->faker->word,
            'phone'     => $this->faker->phoneNumber,
            'email'     => $this->faker->unique()->safeEmail(),
        ];
    }
}
