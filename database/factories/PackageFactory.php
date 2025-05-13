<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['Package1', 'Package2', 'Package3']),
            'number_of_lessons' => fake()->randomDigit(),
            'price_per_lesson' => fake()->randomFloat(2,50,200)
        ];
    }
}
