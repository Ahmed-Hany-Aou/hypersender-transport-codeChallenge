<?php

use App\Models\Company;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use App\Filament\Resources\TripResource;
use function Pest\Livewire\livewire;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('prevents creating a trip when a driver is already booked for an overlapping time', function () {
    // Arrange: Set up the scenario and authenticate a user
    $user = User::factory()->create();
    $this->actingAs($user);
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

    // Act: Try to create a new trip that overlaps
    livewire(TripResource\Pages\CreateTrip::class)
        ->fillForm([
            'name' => 'Conflicting Trip',
            'company_id' => $company->id,
            'driver_id' => $driver->id, // Same driver
            'vehicle_id' => $vehicle2->id, // Different vehicle
            'origin' => 'City A',
            'destination' => 'City B',
            'start_time' => Carbon::now()->addDay()->setHour(10)->setMinute(0), // Tomorrow 10 AM (overlaps)
            'end_time' => Carbon::now()->addDay()->setHour(14)->setMinute(0),   // Tomorrow 2 PM
        ])
        ->call('create')
        ->assertHasFormErrors(['driver_id']); // Assert: Check for a validation error

    // Assert: Also make sure the conflicting trip was NOT created in the database
    $this->assertDatabaseCount('trips', 1);
});

