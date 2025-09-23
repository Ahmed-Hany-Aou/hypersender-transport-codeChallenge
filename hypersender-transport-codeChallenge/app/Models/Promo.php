<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'code',
        'discount',
        'valid_from',
        'valid_until',
        'active',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
