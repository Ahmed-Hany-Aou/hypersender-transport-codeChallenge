<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Trip extends Model
{
     public function scopeActive(Builder $query): Builder
    {
        
        return $query->where('status', 'active');
    }

}
