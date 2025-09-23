<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(), // Automatically creates a company
            'model' => $this->faker->randomElement(['Toyota Camry', 'Honda Civic', 'Ford F-150', 'Tesla Model 3']),
            'plate_number' => $this->faker->unique()->bothify('???-###'),
            'status' => $this->faker->randomElement(['active', 'maintenance']),
        ];
    }
}
