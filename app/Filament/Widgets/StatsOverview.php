<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Locations;
use App\Models\Sector;
use App\Models\Tests;



class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $locationCount = Tests::count();
        $sectorCount = Sector::count();
        //$teacherCount = Teacher::count(); use this when we are ready for this step


        return [
            Stat::make('Locations', $locationCount),            
            Stat::make('Sectors', $sectorCount),
            Stat::make('Available Teachers', '3:12'),        
        ];
    }
}
