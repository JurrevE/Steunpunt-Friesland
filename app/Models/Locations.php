<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'sector_location', 'location_id', 'sector_id');
    }
}
