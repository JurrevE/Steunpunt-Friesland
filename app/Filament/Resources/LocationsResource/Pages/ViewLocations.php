<?php

namespace App\Filament\Resources\LocationsResource\Pages;

use App\Models\Location;
use App\Filament\Resources\LocationsResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Actions;

class ViewLocation extends ViewRecord
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
        $record = $this->getRecord();
        return [
            Actions\Action::make('view on map')
            ->url(route('filament.resources.locations-resource.pages.maps-overview', ['record' => $record->getKey()]))                 
         ];
    }
}
