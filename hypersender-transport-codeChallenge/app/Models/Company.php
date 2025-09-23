<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
      protected $fillable = [
        'name',
        'address',
        'contact_info',
    ];
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
