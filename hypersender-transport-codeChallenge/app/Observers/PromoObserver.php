<?php

namespace App\Observers;

use App\Models\Promo;
use Illuminate\Support\Carbon;

class PromoObserver
{
    /**
     * Handle the Promo "saving" event.
     */
    public function saving(Promo $promo): void
    {
        // Check if the valid_until date is set and is in the past
        if ($promo->valid_until && Carbon::parse($promo->valid_until)->isPast()) {
            $promo->active = false;
        }
    }
}