<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account\Organisation;

use App\Actions\User\Organisation\OrganisationJoinAction;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\StoreOrganisationJoinRequest;
use App\Http\Resources\OrganiserResource;
use App\Models\Organiser;
use Inertia\Response;

class OrganisationJoinController extends FrontendController
{
    public function index(): Response
    {
        abort_if(! empty(user()->organiser), 403);

        $organisers = Organiser::without('media')->orderBy('title')->get();

        return inertia('Account/Organisation/join', [
            'organisers' => OrganiserResource::collection($organisers),
        ]);
    }

    public function store(StoreOrganisationJoinRequest $request, OrganisationJoinAction $organisationJoinAction)
    {
        // TODO Store organisation
    }
}
