<?php

namespace App\Filament\Actions;

use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LocationsExport;

class ExportLocationsAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('export_all') // Provide a unique name here
            ->label('Export All')
            ->action(function () {
                return Excel::download(new LocationsExport, 'locations.xlsx');
            });
    }
}
