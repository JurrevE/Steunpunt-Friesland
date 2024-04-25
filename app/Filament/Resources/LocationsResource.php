<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationsResource\Pages;
use App\Filament\Resources\LocationsResource\RelationManagers;
use App\Models\Locations;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FIlament\Tables\Colums\CheckboxColumn;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ViewAction;

class LocationsResource extends Resource
{
    protected static ?string $model = Locations::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    
    protected static ?string $navigationGroup = 'Sectors'; //Place the corresponding navigation group here

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->label('Name'),
            Forms\Components\TextInput::make('location')
                ->required()
                ->label('Location'),
            Forms\Components\Checkbox::make('under_15')
                ->label('Under 15')
                ->helperText('Check if the location is suitable for ages under 15.'),
            CheckboxList::make('sectors')
                ->relationship('sectors', 'sector_name')
                ->label('Sectors')
                ->helperText('Select the sectors this location belongs to.'),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')
            ->sortable()
            ->searchable(isIndividual: true),
            Tables\Columns\TextColumn::make('location')
            ->icon('heroicon-s-map-pin')
            ->sortable()
            ->searchable(isIndividual: true),
            // Checkbox
            Tables\Columns\CheckboxColumn::make('under_15')
            ->sortable(),
            // Gathering all the sector names(table sectors, column sector_name)
            Tables\Columns\TextColumn::make('sectors.sector_name')
            ->searchable()
            ->badge()
            ->limitList(2)
            ->expandableLimitedList()
            ->listWithLineBreaks()
        ])->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            ViewAction::make()
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocations::route('/create'),
            'edit' => Pages\EditLocations::route('/{record}/edit'),
        ];
    }

    public static function getModel(): string
    {
        return Locations::class;
    }
}
