<?php

namespace App\Filament\Widgets;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransportStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Note: Make sure your Trip, Driver, and Vehicle models exist.
        // If not, you can replace the values with numbers for now, like `->value('12')`.

        return [
            Stat::make('Active Trips', Trip::where('status', 'active')->count())
                ->description('Trips currently in progress')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Available Drivers', Driver::where('status', 'available')->count())
                ->description('Drivers ready for assignment')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Vehicles Ready', Vehicle::where('status', 'ready')->count())
                ->description('Vehicles available for trips')
                ->descriptionIcon('heroicon-m-truck')
                ->color('primary'),
        ];
    }
}