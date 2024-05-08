<?php

namespace App\Filament\Widgets;

use App\Models\Locations;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class LastUpdated extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

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
                IconColumn::make('under_15')
                    ->boolean()
                    ->label('Under 15'),
                TextColumn::make('updated_at')
                    ->date()
            ]);
    }
}
