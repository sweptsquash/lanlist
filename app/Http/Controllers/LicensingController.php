<?php

namespace App\Http\Controllers;

use Inertia\Response;

class LicensingController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('licensing');
    }
}
