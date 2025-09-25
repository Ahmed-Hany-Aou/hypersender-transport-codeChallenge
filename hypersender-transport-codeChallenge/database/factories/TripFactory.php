<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TripFactory extends Factory
{
    public function definition(): array
    {
        $startTime = Carbon::instance($this->faker->dateTimeBetween('-1 month', '+1 month'));
        $endTime = (clone $startTime)->addHours($this->faker->numberBetween(2, 8));
        $origin = $this->faker->city();
        $destination = $this->faker->city();

        return [
            // These lines ensure every trip has the required relationships
            'company_id' => Company::factory(),
            'driver_id' => Driver::factory(),
            'vehicle_id' => Vehicle::factory(),

            'name' => "Trip from {$origin} to {$destination}",
            'origin' => $origin,
            'destination' => $destination,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $this->faker->randomElement(['scheduled', 'active', 'completed', 'cancelled']),
        ];
    }
}

