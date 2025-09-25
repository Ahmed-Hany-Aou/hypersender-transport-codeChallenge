<?php

namespace App\Filament\Widgets;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        // We will cache the results for 1 minute to improve performance
        $cacheKey = 'dashboard_kpis';
        $cacheTimeInSeconds = 60; // 1 minute

        $stats = Cache::remember($cacheKey, $cacheTimeInSeconds, function () {
            // KPI 1: Active Trips (Simplified Logic)
            $activeTrips = Trip::where('status', 'active')->count();

            // KPI 2: Available Drivers
            $availableDrivers = Driver::where('status', 'available')->count();

            // KPI 3: Available Vehicles (The new one!)
            $availableVehicles = Vehicle::where('status', 'active')->count();

            // KPI 4: Trips Completed This Month
            $completedThisMonth = Trip::where('status', 'completed')
                ->whereBetween('end_time', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ])
                ->count();

            return [
                'activeTrips' => $activeTrips,
                'availableDrivers' => $availableDrivers,
                'availableVehicles' => $availableVehicles,
                'completedThisMonth' => $completedThisMonth,
            ];
        });
            
        return [
            Stat::make('Active Trips', $stats['activeTrips'])
                ->description('Trips with an active status')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Available Drivers', $stats['availableDrivers'])
                ->description('Drivers ready for assignment')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Available Vehicles', $stats['availableVehicles'])
                ->description('Vehicles ready for assignment')
                ->descriptionIcon('heroicon-m-truck')
                ->color('warning'),

            Stat::make('Trips Completed This Month', $stats['completedThisMonth'])
                ->description('Successful trips in the current month')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary'),
        ];
    }

    public function getColumns(): int
    {
        // Update the layout to accommodate the new stat card
        return 4;
    }
}

