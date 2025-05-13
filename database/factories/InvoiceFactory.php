<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration_id' => fake()->numberBetween(1,200),
            'invoice_number' => fake()->unique()->randomNumber(),
            'invoice_date' => fake()->date(),
            'amount_excl_vat' => fake()->randomFloat(2, 100, 1000),
            'btw' => fake()->randomFloat(2, 100, 1000),
            'amount_inc_vat' => fake()->randomFloat(2, 100, 1000),
            'invoice_status' => fake()->randomElement(['Unpaid', 'Paid', 'Overdue', 'Canceled'])

        ];
    }
}
