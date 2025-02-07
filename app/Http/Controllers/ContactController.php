<?php

namespace App\Http\Controllers;

use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return inertia('contact');
    }

    public function store()
    {
        // TODO
    }
}
