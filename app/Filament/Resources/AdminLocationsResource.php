<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminLocationsResource\Pages;
use App\Models\Locations;
use Filament\Actions\DeleteAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\IconColumn;
use Filament\Infolists\Components\Tabs;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Filament\Actions\ExportLocationsAction;
use App\Exports\SelectedLocationsExport;
use Illuminate\Support\Collection;

class AdminLocationsResource extends Resource
{
    protected static ?string $model = Locations::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Edit Locaties';
    
    protected static ?string $navigationGroup = 'Admin';

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
                // General Information Block
                Section::make('Algemeen')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->label('Naam'),
                                TextInput::make('location')
                                    ->label('Locatie'),
                                TextInput::make('website')
                                    ->label('Website'),
                                Textarea::make('notes')
                                    ->label('Beschrijving')
                                    ->columnSpan(2),
                            ]),
                    ]),

                // Contact Information Block
                Section::make('Contact')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('contact')
                                    ->label('E-mail'),
                                TextInput::make('phone')
                                    ->label('Telefoon'),
                                TextInput::make('spokesperson')
                                    ->label('Contactpersoon'),
                            ]),
                    ]),

                // Extra Information Block
                Section::make('Extra')
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\Checkbox::make('under_15')
                                    ->label('Onder 15')
                                    ->helperText('Vink aan als de locatie  geschikt is voor kinderen onder de 15'),
                                Forms\Components\CheckboxList::make('sectors')
                                    ->relationship('sectors', 'sector_name')
                                    ->label('Sectoren')
                                    ->helperText('Selecteer de bijbehorende sectoren')
                                    ->columnSpan(2)
                                    ->extraAttributes([
                                        'style' => 'display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;',
                                    ]),
                                Textarea::make('expertise')
                                    ->label('Specialiteit(en)'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->limit('24')
                    ->sortable()
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
                    ->trueLabel('Onder 15')
                    ->falseLabel('Niet onder 15'),
                SelectFilter::make('sectors')
                    ->multiple()
                    ->options(self::getSectorOptions())
                    ->attribute('sectors.sector_name')
                    ->selectablePlaceholder(true)
                    ->columnSpan(3)
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
            ->headerActions([
                ExportLocationsAction::make('export_all'), 
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make()
                    ->label('Export All Data')
                    ->action(function ($records) {
                        $locationIds = $records->pluck('id')->toArray();
                        return Excel::download(new SelectedLocationsExport($locationIds), 'locations.xlsx');
                    }),
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
                Section::make('General Information')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Naam'),
                        IconEntry::make('under_15')
                            ->label('Geschikt voor onder 15')
                            ->boolean(),
                        TextEntry::make('website')
                            ->icon('heroicon-m-globe-alt')
                            ->url(function ($record) {
                                $url = $record->website;
                                // Prepend 'http://' if it doesn't already have a scheme
                                if (!preg_match('/^https?:\/\//', $url)) {
                                    $url = 'http://' . $url;
                                }
                                return $url;
                            })
                            ->openUrlInNewTab(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Section::make('Contact Information')
                    ->schema([
                        TextEntry::make('location')
                            ->icon('heroicon-s-map-pin')
                            ->label('Locatie'),
                        TextEntry::make('spokesperson')
                            ->label('Contactpersoon')
                            ->icon('heroicon-m-user'),
                        TextEntry::make('contact')
                            ->label('E-Mail')
                            ->icon('heroicon-m-envelope')
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1500),
                        TextEntry::make('phone')
                            ->label('Telefoon')
                            ->icon('heroicon-m-phone')
                            ->copyable()
                            ->copyMessage('Copied!')
                            ->copyMessageDuration(1500),
                    ])
                    ->columnSpan(['lg' => 2]),
                Section::make('Sectoren')
                    ->description('Alle sectoren die bij deze locatie horen en de specialiteiten')
                    ->schema([
                        TextEntry::make('sectors.sector_name')
                            ->listWithLineBreaks()
                            ->badge()
                            ->label('Sectoren'),
                        TextEntry::make('expertise')
                            ->label('Specialiteiten')
                    ])
            ])
            ->columns(4)
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
