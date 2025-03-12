<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\FrontendController;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Response;

class RegisteredUserController extends FrontendController
{
    public function create(): Response
    {
        return inertia('Auth/Register', [
            'countries' => CountryResource::collection(Country::all()),
        ]);
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
            'country_id' => $request->country,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home'));
    }
}
