<?php

namespace App\Http\Controllers;

use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('index');
    }
}
