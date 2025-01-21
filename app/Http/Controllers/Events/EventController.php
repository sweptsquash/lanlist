<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Inertia\Response;

class EventController extends Controller
{
    public function index(): Response
    {
        return inertia('events/index');
    }

    public function show(Event $event): Response
    {
        return inertia('events/show');
    }
}
