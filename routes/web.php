<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Resources\LocationsResource\Pages\MapsOverview;

Route::view('/', 'welcome');

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/locations/{record}/map', MapsOverview::class)->name('filament.resources.locations-resource.pages.maps-overview');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
