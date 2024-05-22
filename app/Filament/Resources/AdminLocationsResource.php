<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminLocationsResource\Pages;
use App\Models\Locations;
use Filament\Actions\DeleteAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Infolists\Components\Tabs;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Textarea;

class AdminLocationsResource extends Resource
{
    protected static ?string $model = Locations::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Edit Locaties';
    
    protected static ?string $navigationGroup = 'Admin';  //Place the corresponding navigation group here

    public static function getLabel(): string
    {
        return 'Locations';
    }

    public static function getPluralLabel(): string
    {
        return 'Edit Locations';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Naam'),
                        Forms\Components\TextInput::make('location')
                        ->label('Locatie'),
                        Forms\Components\TextInput::make('Website'),
                        Forms\Components\TextInput::make('Contact'),
                        Forms\Components\TextInput::make('spokesperson')
                        ->label('Contactpersoon'),
                    ]),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Checkbox::make('under_15')
                            ->label('Onder 15')
                            ->helperText('Check if the location is suitable for ages under 15.'),
                        Forms\Components\CheckboxList::make('sectors')
                            ->relationship('sectors', 'sector_name')
                            ->label('Sectoren')
                            ->helpertext('selecteer de bijbehorende sectoren'),
                    ]),
                    Forms\Components\Grid::make(1)
                     ->schema([
                        Textarea::make('expertise')
                        ->label('Specialiteit'),
                     ])
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
                IconColumn::make('under_15')
                    ->label('Onder 15')
                    ->boolean()
                    ->alignment(Alignment::Center),
                Tables\Columns\TextColumn::make('sectors.sector_name')
                    ->label('Sectoren')
                    ->badge()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->listWithLineBreaks(),
            ])
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
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
                    ->query(function (Builder $query, array $data) {
                        if (!empty(array_filter($data))) {
                            $flatData = collect($data)->flatten()->all();
                            $query->whereHas('sectors', function (Builder $q) use ($flatData) {
                                $q->where(function (Builder $q2) use ($flatData) {
                                    foreach ($flatData as $sectorName) {
                                        $q2->orWhere('sector_name', $sectorName);
                                    }
                                });
                            });
                        }
                    }),
            ], 
            layout: FiltersLayout::AboveContent)
            ->persistFiltersInSession()
            ->deferFilters()
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

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
                            ->label('Specialiteiten'),
                    ]),
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
            'index' => Pages\ListAdminLocations::route('/'),
            'create' => Pages\CreateAdminLocations::route('/create'),
            'edit' => Pages\EditAdminLocations::route('/{record}/edit'),
        ];
    }

    public static function getModel(): string
    {
        return Locations::class;
    }
}
