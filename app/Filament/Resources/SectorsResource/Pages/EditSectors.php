<?php

namespace App\Filament\Resources\SectorsResource\Pages;

use App\Filament\Resources\SectorsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSectors extends EditRecord
{
    protected static string $resource = SectorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
