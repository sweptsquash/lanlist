<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Organisation;

use App\Actions\User\Organisation\OrganisationCreateAction;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\StoreOrganisationCreateRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class OrganisationCreateController extends FrontendController
{
    public function index(): Response
    {
        return inertia('Account/Organisation/create');
    }

    public function store(StoreOrganisationCreateRequest $request, OrganisationCreateAction $organisationCreateAction): RedirectResponse
    {
        $organisationCreateAction->execute($request);

        return back()->success('Organisation created.');
    }
}
