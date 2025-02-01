<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaConversionController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::prefix('events')->name('events.')->controller(EventController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::redirect('/map', '/')->name('map');
    Route::get('/{event}', 'show')->name('show');
});

Route::prefix('organisers')->name('organisers.')->group(function () {
    // TODO
});

Route::prefix('venues')->name('venues.')->group(function () {
    // TODO
});

Route::prefix('media')->name('media.')->group(function () {
    Route::get('{media:uuid}/conversions/', MediaConversionController::class)->name('conversion');
    Route::get('{media:uuid}/', MediaController::class)->name('show');
});

include 'auth.php';
include 'old.php';
