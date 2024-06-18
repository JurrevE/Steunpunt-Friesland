<?php

namespace App\Filament\Resources\LocationsResource\Pages;

use App\Filament\Resources\LocationsResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Actions\Button;

class ViewLocation extends ViewRecord
{
    protected static string $resource = LocationsResource::class;

    public function getTitle(): string
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
            Action::make('View on Map')
                ->url(route('filament.resources.locations-resource.pages.maps-overview', ['record' => $record->getKey()]))                 
        ];
    }
}
