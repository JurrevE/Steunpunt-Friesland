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
use Filament\Infolists\Components\Tabs;


class TestsResource extends Resource
{
    protected static ?string $model = Tests::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->label('Name'),
                Forms\Components\TextInput::make('location'),
                Forms\Components\Checkbox::make('under_15')
                ->label('Under 15')
                ->helperText('Check if the location is suitable for ages under 15.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(isIndividual: true)
                    ->limit('24')
                    ->label('Naam'),
                Tables\Columns\TextColumn::make('location')
                    ->icon('heroicon-s-map-pin')
                    ->sortable()
                    ->searchable(isIndividual: true)
                    ->label('Locatie'),
                // Checkbox
                IconColumn::make('under_15')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Dashboard')
                            ->icon('heroicon-m-bars-3-center-left')
                            ->schema([
                                TextEntry::make('name'),
                                IconEntry::make('under_15')
                                    ->boolean(),
                                TextEntry::make('website')
                                    ->icon('heroicon-m-globe-alt'),
                            ]),
                        Tabs\Tab::make('Contact')
                            ->icon('heroicon-m-envelope')
                            ->schema([
                                TextEntry::make('location')
                                    ->icon('heroicon-s-map-pin')
                                    ->label('Location'),
                                TextEntry::make('spokesperson')
                                    ->label('Spokesperson')
                                    ->icon('heroicon-m-user'),
                                TextEntry::make('contact')
                                    ->icon('heroicon-m-envelope')
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1500),
                            ]),
                    ])
                    ->activeTab(1)                
            ])
            ->columns(1)
            ->inlineLabel();
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
