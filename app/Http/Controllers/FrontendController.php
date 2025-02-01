<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * To be used on Inertia response controllers.
 */
class FrontendController extends Controller
{
    public function __construct()
    {
        JsonResource::withoutWrapping();
    }
}
