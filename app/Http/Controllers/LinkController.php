<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class LinkController extends Controller
{
    public function __invoke()
    {
        return inertia('linkus');
    }
}
