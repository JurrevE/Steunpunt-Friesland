<?php

namespace App\Filament\Resources\LocationsResource\Pages;

use App\Models\Location;
use App\Filament\Resources\LocationsResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewLocations extends ViewRecord
{
    protected static string $resource = LocationsResource::class;

    public function getTitle(): string | Htmlable
    {
        $record = $this->getRecord();

        // Check if the record exists and if it has a non-empty name
        if ($record && $record->name) {
            return $record->name;
        } else {
            // If the record's name is null or empty, return a default title
            return 'Untitled Location';
        }
    }

    protected function getActions(): array
    {
        return [];
    }
}
