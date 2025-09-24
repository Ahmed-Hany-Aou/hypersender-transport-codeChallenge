<?php

namespace App\Observers;

use App\Models\Trip;
use Illuminate\Support\Facades\Cache;

class TripObserver
{
    /**
     * Handle the Trip "saved" event.
     */
    public function saved(Trip $trip): void
    {
        Cache::forget('dashboard_kpis');
    }

    /**
     * Handle the Trip "deleted" event.
     */
    public function deleted(Trip $trip): void
    {
        Cache::forget('dashboard_kpis');
    }
}
