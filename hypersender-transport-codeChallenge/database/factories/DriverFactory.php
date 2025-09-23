<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(), // Automatically creates a company
            'name' => $this->faker->name(),
            'license_number' => $this->faker->unique()->bothify('??######'),
            'phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['available', 'on-trip', 'on-leave']),
        ];
    }
}
