<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'model',
        'plate_number',
        'status',
        'company_id',
    ];
      public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
