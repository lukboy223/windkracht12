<?php

namespace Database\Factories;

use App\Models\Instructor;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration_id' => fake()->unique()->numberBetween(1,200),
            'instructor_id' => fake()->numberBetween(1,200),
            'car_id' => fake()->numberBetween(1,5),
            'start_date' => fake()->date(),
            'start_time' => fake()->time(),
            'end_date' => fake()->date(),
            'end_time' => fake()->time(),
            'lesson_status' => fake()->randomElement(['Planned', 'Completed', 'Canceled']),
        ];
    }
}
