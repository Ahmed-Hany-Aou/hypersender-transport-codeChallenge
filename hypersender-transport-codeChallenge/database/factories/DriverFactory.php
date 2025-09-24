<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'license_number' => $this->faker->unique()->bothify('??######'),
            'phone' => $this->faker->phoneNumber(),
            'status' => 'available',
        ];
    }
}