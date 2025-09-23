<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Driver;
use App\Models\Promo;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default admin user to log in with
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@hypersender.com',
            'password' => bcrypt('password'),
        ]);

        $promos = Promo::factory(15)->create();
        $activePromos = $promos->where('active', true);

        // Create 5 companies, and for each company, create 10 drivers and 15 vehicles
        $companies = Company::factory(5)
            ->hasDrivers(10)
            ->hasVehicles(15)
            ->create();

        // For each company, create a set of trips
        foreach ($companies as $company) {
            // Get all drivers and vehicles for the current company
            $drivers = $company->drivers;
            $vehicles = $company->vehicles;

            // Create 20 trips with random drivers and vehicles from the company's fleet
            Trip::factory(20)->create([
                'company_id' => $company->id,
                'driver_id' => $drivers->random()->id,
                'vehicle_id' => $vehicles->random()->id,
            ]);
        }

        // Create a specific trip that is guaranteed to be "active" right now for testing KPIs
        $activeTripCompany = $companies->first();
        Trip::factory()->create([
            'company_id' => $activeTripCompany->id,
            'driver_id' => $activeTripCompany->drivers->first()->id,
            'vehicle_id' => $activeTripCompany->vehicles->first()->id,
            'start_time' => Carbon::now()->subHour(),
            'end_time' => Carbon::now()->addHour(),
            'status' => 'active',
        ]);
    }
}
