<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DemoStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Active Trips', '12')
                ->description('Currently in progress')
                ->descriptionIcon('heroicon-m-truck')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Available Drivers', '8')
                ->description('Ready for assignment')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->chart([4, 3, 2, 8, 6, 5, 4, 3]),

            Stat::make('Fleet Vehicles', '15')
                ->description('Operational & ready')
                ->descriptionIcon('heroicon-m-truck')
                ->color('warning')
                ->chart([2, 4, 3, 2, 1, 5, 4, 6]),

            Stat::make('Monthly Completed', '160')
                ->description('Trips completed this month')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('primary')
                ->chart([15, 22, 18, 27, 25, 30, 28, 35]),
        ];
    }

    public function getColumns(): int
    {
        return 4;
    }
}
