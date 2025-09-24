<?php

use App\Models\Company;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use App\Filament\Resources\TripResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;
use Illuminate\Support\Carbon;

// This trait will automatically run migrations on a test database
uses(RefreshDatabase::class);

it('prevents creating a trip when a driver is already booked for an overlapping time', function () {
    // Arrange: Set up a user and authenticate them
    $user = User::factory()->create();
    $this->actingAs($user);

    // Arrange: Set up the scenario
    $company = Company::factory()->create();
    $driver = Driver::factory()->for($company)->create();
    $vehicle1 = Vehicle::factory()->for($company)->create();
    $vehicle2 = Vehicle::factory()->for($company)->create();

    // The existing trip for the driver
    Trip::factory()->for($company)->create([
        'driver_id' => $driver->id,
        'vehicle_id' => $vehicle1->id,
        'start_time' => Carbon::now()->addDay()->setHour(9)->setMinute(0),  // Tomorrow 9 AM
        'end_time' => Carbon::now()->addDay()->setHour(12)->setMinute(0), // Tomorrow 12 PM
    ]);

    // Act: Try to create a new trip that overlaps with the same driver
    livewire(TripResource\Pages\CreateTrip::class)
        ->fillForm([
            'company_id' => $company->id,
            'driver_id' => $driver->id, // Same driver
            'vehicle_id' => $vehicle2->id, // Different vehicle
            'origin' => 'City A',
            'destination' => 'City B',
            'start_time' => Carbon::now()->addDay()->setHour(10)->setMinute(0), // Tomorrow 10 AM (overlaps)
            'end_time' => Carbon::now()->addDay()->setHour(14)->setMinute(0),   // Tomorrow 2 PM
        ])
        ->call('create')
        ->assertHasErrors(['data.driver_id']); // Assert: Check for a validation error on the driver field

    // Assert: Also make sure the conflicting trip was NOT created in the database
    $this->assertDatabaseCount('trips', 1);
});

it('prevents creating a trip when a vehicle is already booked for an overlapping time', function () {
    // Arrange: Set up a user and authenticate them
    $user = User::factory()->create();
    $this->actingAs($user);

    // Arrange: Set up the scenario
    $company = Company::factory()->create();
    $driver1 = Driver::factory()->for($company)->create();
    $driver2 = Driver::factory()->for($company)->create();
    $vehicle = Vehicle::factory()->for($company)->create();

    // The existing trip for the vehicle
    Trip::factory()->for($company)->create([
        'driver_id' => $driver1->id,
        'vehicle_id' => $vehicle->id, // Same vehicle
        'start_time' => Carbon::now()->addDay()->setHour(9)->setMinute(0),  // Tomorrow 9 AM
        'end_time' => Carbon::now()->addDay()->setHour(12)->setMinute(0), // Tomorrow 12 PM
    ]);

    // Act: Try to create a new trip that overlaps with the same vehicle
    livewire(TripResource\Pages\CreateTrip::class)
        ->fillForm([
            'company_id' => $company->id,
            'driver_id' => $driver2->id, // Different driver
            'vehicle_id' => $vehicle->id, // Same vehicle
            'origin' => 'City A',
            'destination' => 'City B',
            'start_time' => Carbon::now()->addDay()->setHour(11)->setMinute(0), // Tomorrow 11 AM (overlaps completely)
            'end_time' => Carbon::now()->addDay()->setHour(11)->setMinute(30), // Tomorrow 11:30 AM
        ])
        ->call('create')
        ->assertHasErrors(['data.vehicle_id']); // Assert: Check for a validation error on the vehicle field

    // Assert: Also make sure the conflicting trip was NOT created in the database
    $this->assertDatabaseCount('trips', 1);
});
