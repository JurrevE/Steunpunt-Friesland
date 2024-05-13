<?php

namespace App\Filament\Resources\TestsResource\Pages;

use App\Filament\Resources\TestsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTests extends EditRecord
{
    protected static string $resource = TestsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
