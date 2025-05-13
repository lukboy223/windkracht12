<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => fake()->numberBetween(1,200),
            'date' => fake()->date(),
            'status' => fake()->randomElement(['Pending', 'Completed', 'Failed', 'Refunded'])
        ];
    }
}
