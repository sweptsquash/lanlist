<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return inertia('contact');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Notification::send(config('app.admin'), new ContactMail($validated, $request->ip()));

        return back()->success('Message sent successfully!');
    }
}
