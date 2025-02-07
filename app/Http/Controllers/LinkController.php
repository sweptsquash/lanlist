<?php

namespace App\Http\Controllers;

class LinkController extends Controller
{
    public function __invoke()
    {
        return inertia('linkus');
    }
}
