<?php

namespace App\Http\Controllers\Account;

use App\Actions\User\UpdateUserAction;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class AccountDetailController extends FrontendController
{
    public function index(): Response
    {
        return inertia('Account/index', [
            'countries' => CountryResource::collection(Country::all()),
            'timezones' => collect(timezone_identifiers_list())
                ->map(function ($timezone) {
                    return ['id' => $timezone, 'name' => $timezone];
                }),
        ]);
    }

    public function update(UpdateAccountRequest $request, UpdateUserAction $updateUserAction): RedirectResponse
    {
        $updateUserAction->execute($request);

        return back()->success('Account updated.');
    }
}
