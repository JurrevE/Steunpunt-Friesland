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
                    ->label('Onder 15')
                    ->boolean()
                    ->alignment(Alignment::Center),
                    Tables\Columns\TextColumn::make('sectors.sector_name')
                    ->searchable(isIndividual: true)
                    ->label('Sectoren')
                    ->badge()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->listWithLineBreaks()
            ])
            ->filters([
                TernaryFilter::make('under_15')
                ->label('Geschikt voor onder de 15')
                ->placeholder('Alles')
                ->trueLabel('Geschikt')
                ->falseLabel('Niet geschikt'),
                SelectFilter::make('Sectoren')
                ->multiple()
                ->options([
                    'Afbouw, hout en onderhoud: AH&O' => 'Afbouw, hout en onderhoud: AH&O',
                    'Bouw en infra: B&I' => 'Bouw en infra: B&I',
                    'Handel en ondernemerschap: H&O' => 'Handel en ondernemerschap: H&O',
                    'Horeca en bakkerij: H&B' => 'Horeca en bakkerij: H&B',
                    'ICT: ICT' => 'ICT: ICT',
                    'Media en vormgeving: Me&V' => 'Media en vormgeving: Me&V',
                    'Mobiliteit en voertuigen: Mo&V' => 'Mobiliteit en voertuigen: Mo&V',
                    'Techniek en procesindustrie: T&P' => 'Techniek en procesindustrie: T&P',
                    'Transport, scheepvaart en logistiek: TS&L' => 'Transport, scheepvaart en logistiek: TS&L',
                    'Voedsel, natuur en leefomgeving: VN&L' => 'Voedsel, natuur en leefomgeving: VN&L',
                    'Zorg en Welzijn: Z&W' => 'Zorg en Welzijn: Z&W',
                    'Economie en administratie: E&A' => 'Economie en administratie: E&A',
                    'Ambacht, laboratorium en gezondheidstechniek: AL&G' => 'Ambacht, laboratorium en gezondheidstechniek: AL&G',
                ])
                ->attribute('sectors')
            ], layout: FiltersLayout::AboveContent)
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
