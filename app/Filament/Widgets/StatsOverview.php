<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Locations;
use App\Models\Sector;


class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $locationCount = Locations::count();
        $sectorCount = Sector::count();
        //$TeacherCount = Teacher::count(); use this when we are ready for this step


        return [
            Stat::make('Locations', $locationCount),            
            Stat::make('Sectors', $sectorCount),
            Stat::make('Teachers', '3:12'),        
        ];
    }
}
