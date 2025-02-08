<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class AccountConnectionsController extends FrontendController
{
    public function index(): Response
    {
        return inertia('Account/connections');
    }

    public function destroy(Request $request): RedirectResponse
    {
        abort_if(! $request->has('service'), 400, 'No service passed.');

        $service = str($request->input('service'))->lower()->toString();

        $serviceNotSupported = ! in_array($service, [
            'discord',
            'twitch',
        ]);

        abort_if($serviceNotSupported, 400, 'Non supported service passed.');

        user()->update(["{$service}_id" => null]);

        return back()->success("{$service} account disconnected.");
    }
}
