<?php

namespace App\Filament\Widgets;

use App\Models\Locations;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class LastUpdated extends BaseWidget
{
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->query(Locations::query())
            ->columns([
                TextColumn::make('name')
                    ->label('Location Name'),
                TextColumn::make('location')
                    ->label('Location'),
                CheckboxColumn::make('under_15')
                    ->label('Under 15')
            ]);
    }
}
