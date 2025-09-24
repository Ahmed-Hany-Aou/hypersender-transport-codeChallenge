<?php

namespace App\Filament\Widgets;

use App\Models\Driver;
use App\Models\Trip;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $cacheKey = 'dashboard_kpis';
        $cacheTimeInSeconds = 300; // 5 minutes

        $stats = Cache::remember($cacheKey, $cacheTimeInSeconds, function () {
            // KPI 1: Active Trips Right Now (Corrected Logic)
            $activeTrips = Trip::where('status', 'active') 
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->count();

            // KPI 2: Available Drivers
            $availableDrivers = Driver::where('status', 'available')->count();

            // KPI 3: Trips Completed This Month
            $completedThisMonth = Trip::where('status', 'completed')
                ->whereBetween('end_time', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ])
                ->count();

            return [
                'activeTrips' => $activeTrips,
                'availableDrivers' => $availableDrivers,
                'completedThisMonth' => $completedThisMonth,
            ];
        });
            
        return [
            Stat::make('Active Trips', $stats['activeTrips'])
                ->description('Trips currently in progress')
                ->descriptionIcon('heroicon-m-truck')
                ->color('success'),

            Stat::make('Available Drivers', $stats['availableDrivers'])
                ->description('Drivers ready for assignment')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Trips Completed This Month', $stats['completedThisMonth'])
                ->description('Successful trips in the current month')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary'),
        ];
    }

    public function getColumns(): int
    {
        return 3;
    }
}

    

