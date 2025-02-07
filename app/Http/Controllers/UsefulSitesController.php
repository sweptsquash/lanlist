<?php

namespace App\Http\Controllers;

use Inertia\Response;

class UsefulSitesController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('useful-sites');
    }
}
