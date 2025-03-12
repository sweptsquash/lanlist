<?php

declare(strict_types=1);

namespace App\Actions\User\Organisation;

use App\Http\Requests\StoreOrganisationCreateRequest;
use App\Models\Organiser;
use App\Models\User;

class OrganisationCreateAction
{
    public function execute(StoreOrganisationCreateRequest $request, ?User $user = null): Organiser
    {
        if (! $user) {
            $user = user();
        }

        $organiser = Organiser::create([
            'title' => $request->title,
            'website' => $request->website,
            'steam_group_url' => $request->steam_group_url,
            'blurb' => $request->blurb,
        ]);

        $user->organiser()->syncWithoutDetaching($organiser);

        return $organiser;
    }
}
