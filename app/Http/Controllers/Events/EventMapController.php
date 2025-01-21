<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Inertia\Response;

class EventMapController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('events/map');
    }
}
