<?php

use App\Http\Controllers\Events\EventController;
use App\Http\Controllers\HomeController;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
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

// Old Link Redirects
Route::redirect('licensing.php', '/licensing', 301); // TODO

Route::redirect('linkus.php', '/link-us', 301); // TODO

Route::redirect('contact.php', '/contact', 301); // TODO

Route::redirect('cookies.php', '/cookies', 301); // TODO

Route::redirect('usefulRelatedSites.php', '/useful-related-sites', 301); // TODO

Route::redirect('login.php', '/login', 301); // TODO

Route::redirect('logout.php', '/logout', 301); // TODO

Route::redirect('register.php', '/register', 301); // TODO

Route::redirect('formHandler.php?formClazz=FormRequestPasswordReset', '/forgot-password', 301); // TODO

Route::redirect('eventsMap.php', '/', 301);

Route::redirect('eventsList.php', '/events', 301); // TODO

Route::redirect('listVenues.php', '/venues', 301); // TODO

Route::redirect('listOrganizers.php', '/organisers', 301); // TODO

Route::get('viewEvent.php', function (Request $request) {
    $event = Event::firstOrFail($request->query('id'));

    return redirect(route('events.show', $event), 301);
});

Route::get('viewVenue.php', function (Request $request) {
    $venue = Venue::firstOrFail($request->query('id'));

    return redirect(route('venues.show', $venue), 301);
});

include 'auth.php';
