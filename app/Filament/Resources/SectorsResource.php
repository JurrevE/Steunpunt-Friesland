<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectorsResource\Pages;
use App\Filament\Resources\SectorsResource\RelationManagers;
use App\Models\Sectors;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ViewAction;
use app\Filament\Resources\SectorsResource\Pages\ViewSector;

class SectorsResource extends Resource
{
    protected static ?string $model = Sectors::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
    
    protected static ?string $navigationGroup = 'Admin';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sector_name')
                ->required()
                ->label('Name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sector_name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make(),
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
            'index' => Pages\ListSectors::route('/'),
            'create' => Pages\CreateSectors::route('/create'),
            'edit' => Pages\EditSectors::route('/{record}/edit'),
            'view' => Pages\ViewSector::route('/{record}')
        ];
    }
}
