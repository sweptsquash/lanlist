<?php

use App\Http\Controllers\Events\EventController;
use App\Http\Controllers\Events\EventMapController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::prefix('events')->name('events.')->controller(EventController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/map', EventMapController::class)->name('map');
    Route::get('/{event}', 'show')->name('show');
});

Route::prefix('organisers')->name('organisers.')->group(function () {
    // TODO
});

Route::prefix('venues')->name('venues.')->group(function () {
    // TODO
});

// TODO: Contact, Cookies, Sitemap, Terms, Privacy, etc.
