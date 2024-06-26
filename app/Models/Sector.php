<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function locations()
    {
        return $this->belongsToMany(Locations::class, 'sector_location', 'sector_id', 'location_id');
    }
}
