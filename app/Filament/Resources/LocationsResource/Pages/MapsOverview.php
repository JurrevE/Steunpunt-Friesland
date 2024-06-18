<?php

namespace App\Filament\Resources\LocationsResource\Pages;

use App\Filament\Resources\LocationsResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class MapsOverview extends Page
{
    protected static string $resource = LocationsResource::class;

    protected static string $view = 'filament.resources.locations-resource.pages.maps-overview';


    use InteractsWithRecord;
    public function overview($record)
    {
        // Your logic for the maps overview page
    }
    
    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }



}
