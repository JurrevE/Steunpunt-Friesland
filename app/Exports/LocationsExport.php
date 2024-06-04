<?php

namespace App\Exports;

use App\Models\Locations;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LocationsExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return Locations::query()->with('sectors');
    }

    public function headings(): array
    {
        return [
            'Naam',
            'Locatie',
            'Onder 15',
            'Sectoren',
            'Website',
            'Email',
            'Telefoon',
            'Contact persoon',
            'Beschrijving',
            'Specialiteiten'
        ];
    }

    public function map($location): array
    {
        return [
            $location->name,
            $location->location,
            $location->under_15 ? 'Ja' : 'Nee',
            $location->sectors->pluck('sector_name')->join(', '),
            $location->website,
            $location->contact,
            $location->phone,
            $location->spokesperson,
            $location->notes,
            $location->expertise
        ];
    }
}
