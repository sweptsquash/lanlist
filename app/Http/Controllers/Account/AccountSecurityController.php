<?php

namespace App\Http\Controllers\Account;

use App\Actions\User\UpdateUserPasswordAction;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\UpdateAccountPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class AccountSecurityController extends FrontendController
{
    public function index(): Response
    {
        return inertia('Account/security');
    }

    public function update(
        UpdateAccountPasswordRequest $request,
        UpdateUserPasswordAction $updateUserPasswordAction
    ): RedirectResponse {
        $updateUserPasswordAction->execute($request);

        return back()->success('Password updated.');
    }
}
