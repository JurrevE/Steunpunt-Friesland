<?php

use App\Filament\Resources\LocationsResource\Pages\MapsOverview;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/admin/locations/{record}/maps', [MapsOverview::class, 'overview'])
    ->name('filament.resources.locations-resource.pages.maps-overview');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
