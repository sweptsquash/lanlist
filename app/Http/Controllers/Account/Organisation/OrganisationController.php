<?php

namespace App\Http\Controllers\Account\Organisation;

use App\Http\Controllers\FrontendController;
use App\Http\Resources\OrganiserResource;
use Inertia\Response;

class OrganisationController extends FrontendController
{
    public function index(): Response
    {
        return inertia('Account/Organisation/index', [
            'organiser' => user()->organiser ? OrganiserResource::make(user()->organiser) : null,
        ]);
    }

    public function update()
    {
        // TODO Update organisation
    }
}
