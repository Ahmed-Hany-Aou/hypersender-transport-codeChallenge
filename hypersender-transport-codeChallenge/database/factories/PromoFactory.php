<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create a random start date within the last 2 months or the next month
        $validFrom = Carbon::instance($this->faker->dateTimeBetween('-2 months', '+1 month'));
        
        // Create an end date that is between 1 week and 2 months after the start date
        $validUntil = (clone $validFrom)->addDays($this->faker->numberBetween(7, 60));

        return [
            'code' => strtoupper($this->faker->unique()->bothify('??####??')),
            'discount' => $this->faker->randomFloat(2, 5, 50), // Discount between 5.00 and 50.00
            'valid_from' => $validFrom->toDateString(),
            'valid_until' => $validUntil->toDateString(),
            'active' => $this->faker->boolean(80), // 80% chance of being active
        ];
    }
}
