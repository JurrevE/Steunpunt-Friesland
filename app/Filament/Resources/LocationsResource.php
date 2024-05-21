<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationsResource\Pages;
use App\Filament\Resources\LocationsResource\RelationManagers;
use App\Models\Locations;
use Doctrine\DBAL\Schema\Schema;
use Filament\Actions\DeleteAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TernaryFilter;
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
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Infolists\Components\Tabs;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Filters\SelectFilter;

class LocationsResource extends Resource
{
    protected static ?string $model = Locations::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    
    protected static ?string $navigationGroup = 'Sectors'; //Place the corresponding navigation group here

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
                CheckboxList::make('sectors')
                    ->relationship('sectors', 'sector_name')
                    ->label('Sectoren')
                    ->helpertext('selecteer de bijbehorende sectoren'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->limit('24')
                    ->label('Naam'),
                Tables\Columns\TextColumn::make('location')
                    ->icon('heroicon-s-map-pin')
                    ->sortable()
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->label('Locatie'),
                // Checkbox
                IconColumn::make('under_15')
                    ->label('Onder 15')
                    ->boolean()
                    ->alignment(Alignment::Center),
                Tables\Columns\TextColumn::make('sectors.sector_name')
                    ->label('Sectoren')
                    ->badge()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->listWithLineBreaks()
            ])
            ->searchOnBlur()          
            ->filters([
                TernaryFilter::make('under_15')
                    ->label('Geschikt voor onder de 15')
                    ->placeholder('Alles')
                    ->trueLabel('Geschikt')
                    ->falseLabel('Niet geschikt'),
                SelectFilter::make('sectors')
                    ->multiple()
                    ->options(self::getSectorOptions())
                    ->attribute('sectors.sector_name')
                    ->selectablePlaceholder(true)
                    ->query(function ($query, array $data) {
                        // Check if the data is not empty
                        if (!empty(array_filter($data))) {
                            $flatData = collect($data)->flatten()->all();
                            $query->whereHas('sectors', function ($q) use ($flatData) {
                                $q->whereIn('sector_name', $flatData);
                            });
                        }
                    })
            ], 
            layout: FiltersLayout::AboveContent)
            ->deferFilters()

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ]);
            
    }

    /**
     * Get sector options from the database.
     *
     * @return array
     */
    protected static function getSectorOptions(): array
    {
        $options = \App\Models\Sector::pluck('sector_name', 'sector_name')->toArray();
        asort($options); // Sort the options alphabetically
        return $options;
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
                    ->activeTab(1),
                    
                    Section::make('Sectoren')
                        ->description('Alle sectoren die bij deze locatie horen en de specialiteiten')
                        ->schema([
                            TextEntry::make('sectors.sector_name')
                            ->badge()    
                            ->label('Sectoren'),
                            TextEntry::make('expertise')
                            ->label('Specialiteiten')
                        ])              
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocations::route('/create'),
            'edit' => Pages\EditLocations::route('/{record}/edit'),
            'view' => Pages\ViewLocation::route('/{record}'),        
        ];
    }

    public static function getModel(): string
    {
        return Locations::class;
    }
}
