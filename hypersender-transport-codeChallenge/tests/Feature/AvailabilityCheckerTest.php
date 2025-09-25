<?php

use App\Filament\Pages\AvailabilityChecker;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->company = Company::factory()->create();
    $this->actingAs(User::factory()->create());
});

it('filters out drivers who are booked during the selected time', function () {
    // Arrange
    $availableDriver = Driver::factory()->create(['company_id' => $this->company->id, 'name' => 'Available Driver']);
    $bookedDriver = Driver::factory()->create(['company_id' => $this->company->id, 'name' => 'Booked Driver']);
    Trip::factory()->create([
        'driver_id' => $bookedDriver->id,
        'start_time' => now()->addHours(1),
        'end_time' => now()->addHours(3),
    ]);

    // Act & Assert
    livewire(AvailabilityChecker::class)
        ->set('data.startTime', now())
        ->set('data.endTime', now()->addHours(4))
        ->assertSee($availableDriver->name)
        ->assertDontSee($bookedDriver->name);
});

it('filters out vehicles that are booked during the selected time', function () {
    // Arrange
    $availableVehicle = Vehicle::factory()->create(['company_id' => $this->company->id, 'plate_number' => 'AVAILABLE-123']);
    $bookedVehicle = Vehicle::factory()->create(['company_id' => $this->company->id, 'plate_number' => 'BOOKED-456']);
    Trip::factory()->create([
        'vehicle_id' => $bookedVehicle->id,
        'start_time' => now()->addHours(1),
        'end_time' => now()->addHours(3),
    ]);

    // Act & Assert
    livewire(AvailabilityChecker::class)
        ->set('data.startTime', now())
        ->set('data.endTime', now()->addHours(4))
        ->assertSee($availableVehicle->plate_number)
        ->assertDontSee($bookedVehicle->plate_number);
});

it('shows a driver whose trip ends exactly when the search period starts', function () {
    // Arrange
    $driver = Driver::factory()->create(['company_id' => $this->company->id, 'name' => 'Edge Case Driver']);
    Trip::factory()->create([
        'driver_id' => $driver->id,
        'start_time' => now()->subHours(2),
        'end_time' => now(),
    ]);

    // Act & Assert
    livewire(AvailabilityChecker::class)
        ->set('data.startTime', now())
        ->set('data.endTime', now()->addHours(4))
        ->assertSee($driver->name);
});

it('filters out drivers who are not available, even if they have no trips', function () {
    // Arrange
    $onLeaveDriver = Driver::factory()->create([
        'company_id' => $this->company->id,
        'name' => 'On Leave Driver',
        'status' => 'on-leave',
    ]);

    // Act & Assert
    livewire(AvailabilityChecker::class)
        ->set('data.startTime', now())
        ->set('data.endTime', now()->addHours(4))
        ->assertDontSee($onLeaveDriver->name);
});

it('filters out vehicles that are under maintenance', function () {
    // Arrange
    $activeVehicle = Vehicle::factory()->create(['company_id' => $this->company->id, 'status' => 'active', 'plate_number' => 'ACTIVE-789']);
    $maintenanceVehicle = Vehicle::factory()->create(['company_id' => $this->company->id, 'status' => 'maintenance', 'plate_number' => 'MAINT-XYZ']);

    // Act & Assert
    livewire(AvailabilityChecker::class)
        ->set('data.startTime', now())
        ->set('data.endTime', now()->addHours(4))
        ->assertSee($activeVehicle->plate_number)
        ->assertDontSee($maintenanceVehicle->plate_number);
});

