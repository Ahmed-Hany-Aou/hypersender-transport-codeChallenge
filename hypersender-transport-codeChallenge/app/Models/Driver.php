<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'license_number',
        'phone',
        'company_id',
    ];
     public function company()
    {
        return $this->belongsTo(Company::class);
        
    }
}

 