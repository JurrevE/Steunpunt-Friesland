<x-filament-panels::page>
<!-- filament/resources/locations-resource/pages/maps-overview.blade.php -->

@extends('filament::page')

@section('content')
    <h1>Maps Overview</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $location->name }}</td>
            </tr>
        </tbody>
    </table>
@endsection

</x-filament-panels::page>
