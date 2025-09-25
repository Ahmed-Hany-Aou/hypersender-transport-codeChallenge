<?php

use App\Filament\Widgets\DashboardStats;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use function Pest\Livewire\livewire;
use App\Models\Vehicle;
uses(RefreshDatabase::class);

beforeEach(function () {
    Cache::flush();
    $this->actingAs(User::factory()->create());
});

it('correctly calculates and displays the number of available drivers', function () {
    // Arrange
    Driver::factory()->count(5)->create(['status' => 'available']);
    Driver::factory()->count(2)->create(['status' => 'on-trip']);

    // Act & Assert
    livewire(DashboardStats::class)
        ->assertSee('Available Drivers')
        ->assertSee('5');
});

it('correctly calculates and displays the number of trips completed this month', function () {
    // Arrange
    Trip::factory()->count(3)->create(['status' => 'completed', 'end_time' => now()->subDays(2)]);
    Trip::factory()->count(2)->create(['status' => 'completed', 'end_time' => now()->subMonth()]);

    // Act & Assert
    livewire(DashboardStats::class)
        ->assertSee('Trips Completed This Month')
        ->assertSee('3');
});

it('correctly calculates and displays the number of active trips', function () {
    // Arrange
    Trip::factory()->count(2)->create(['status' => 'active', 'start_time' => now()->subHour(), 'end_time' => now()->addHour()]);
    Trip::factory()->create(['status' => 'scheduled', 'start_time' => now()->subHour(), 'end_time' => now()->addHour()]);
    Trip::factory()->create(['status' => 'cancelled', 'start_time' => now()->subHour(), 'end_time' => now()->addHour()]);

    // Act & Assert
    livewire(DashboardStats::class)
        ->assertSee('Active Trips')
        ->assertSee('3');
});

it('correctly calculates and displays the number of available vehicles', function () {
    // Arrange: Create vehicles with different statuses. 'active' means available.
    Vehicle::factory()->count(7)->create(['status' => 'active']);
    Vehicle::factory()->count(3)->create(['status' => 'maintenance']);

     // Act & Assert: Render the widget and check the stat
    livewire(DashboardStats::class)
        ->assertSee('Available Vehicles')
        ->assertSee('7');

}); // These should be ignored
