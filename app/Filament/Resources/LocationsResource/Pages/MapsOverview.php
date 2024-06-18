<?php

namespace App\Filament\Resources\LocationsResource\Pages;

use Filament\Resources\Pages\Page;
use App\Filament\Resources\LocationsResource;
use App\Models\Locations;

class MapsOverview extends Page
{
    protected static string $resource = LocationsResource::class;

    protected static string $view = 'filament.resources.locations-resource.pages.maps-overview';

    public function map($record)
    {
        return view(static::$view, ['record' => $record]);
    }
}
