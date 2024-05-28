<?php

namespace App\Filament\Resources\AdminLocationsResource\Pages;

use App\Filament\Resources\AdminLocationsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminLocations extends EditRecord
{
    protected static string $resource = AdminLocationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
