<?php

declare(strict_types=1);

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::redirect('licensing.php', '/licensing', 301);

Route::redirect('linkus.php', '/link-us', 301);

Route::redirect('contact.php', '/contact', 301);

Route::redirect('cookies.php', '/cookies', 301);

Route::redirect('usefulRelatedSites.php', '/useful-related-sites', 301);

Route::redirect('login.php', '/login', 301);

Route::redirect('logout.php', '/logout', 301);

Route::redirect('register.php', '/register', 301);

Route::redirect('formHandler.php?formClazz=FormRequestPasswordReset', '/forgot-password', 301);

Route::redirect('eventsMap.php', '/', 301);

Route::redirect('eventsList.php', '/events', 301);

Route::redirect('listVenues.php', '/venues', 301);

Route::redirect('listOrganizers.php', '/organisers', 301);

Route::get('viewEvent.php', function (Request $request) {
    $event = Event::firstOrFail($request->query('id'));

    return redirect(route('events.show', $event), 301);
});

Route::get('viewVenue.php', function (Request $request) {
    $venue = Venue::firstOrFail($request->query('id'));

    return redirect(route('venues.show', $venue), 301);
});
