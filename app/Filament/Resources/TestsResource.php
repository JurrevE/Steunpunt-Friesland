<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestsResource\Pages;
use App\Filament\Resources\TestsResource\RelationManagers;
use App\Models\Tests;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use FIlament\Tables\Colums\CheckboxColumn;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Tables\Columns\IconColumn;


class TestsResource extends Resource
{
    protected static ?string $model = Tests::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Zorglocatie')
                ->required()
                ->label('Name'),
                Forms\Components\TextInput::make('Plaats')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Zorglocatie')
                ->sortable()
                ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('Plaats')
                ->sortable()
                ->searchable(isIndividual: true),
               
            ])
            ->filters([
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
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('Zorglocatie'),
                TextEntry::make('Plaats')
                ->icon('heroicon-s-map-pin')
                ->label('Location'),
                TextEntry::make('mailadres')
                ->icon('heroicon-m-envelope')
                ->copyable()
                ->copyMessage('Copied!')
                ->copyMessageDuration(1500),
                // IconEntry::make('under_15')
                // ->boolean(),
                Section::Make('Sectors')
                ->description('All suitable sectors')
                ->label('Sectors')
                ->collapsible()
                    ->schema([
                        TextEntry::make('sectors.sector_name')
                        ->badge()
                        ->hiddenLabel(),
                    ])
                 
            ])
            ->columns(3);
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
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTests::route('/create'),
            'edit' => Pages\EditTests::route('/{record}/edit'),
        ];
    }
}
