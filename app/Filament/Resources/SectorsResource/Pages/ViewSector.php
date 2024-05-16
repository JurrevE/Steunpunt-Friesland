<?php

namespace app\Filament\Resources\SectorsResource\Pages;

use App\Filament\Resources\SectorsResource;
use App\Models\Sectors;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Actions;


class ViewSector extends ViewRecord
{
    protected static string $resource = SectorsResource::class;

    public function getTitle(): string | Htmlable
{
    $record = $this->getRecord();

    // Check if the record and its title property are set
    if ($record && $record->sector_name) {
        return $record->sector_name;
    } else {
        // If the record's title is null or empty, return a default title
        return 'Untitled Sector';
    }
}
}