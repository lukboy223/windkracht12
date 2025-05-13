<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'user_id' => User::factory()
            ,'street_name' => fake()->streetName()
            ,'house_number' => fake()->randomNumber(5)
            ,'postal_code' => fake()->unique()->regexify('[1-9]{3}[A-Z]{2}')
            ,'place' => fake()->city()
            ,'mobile' => fake()->e164PhoneNumber()
        ];
    }
}
