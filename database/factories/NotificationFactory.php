<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1,200),
            'target_audience' => fake()->randomElement(['Student', 'Instructor', 'Both']),
            'message' => fake()->text(),
            'type' => fake()->randomElement([
                'Sick', 
                'Lesson Change', 
                'Lesson Cancellation', 
                'Lesson Pickup Address Change', 
                'Lesson Goal Change'
            ]),
            'date' => fake()->dateTime()
        ];
    }
}
