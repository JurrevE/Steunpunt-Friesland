<?php

namespace App\Filament\Resources\TestsResource\Pages;

use App\Filament\Resources\TestsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTests extends CreateRecord
{
    protected static string $resource = TestsResource::class;
}
