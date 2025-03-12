<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\FrontendController;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpFoundationRedirectResponse;

class DiscordAuthController extends FrontendController
{
    public function index(): HttpFoundationRedirectResponse
    {
        if (user() && user()->discord_id) {
            session()->put('connection_oauth_setup', true);
        }

        return Socialite::driver('discord')->redirect();
    }

    public function store(): RedirectResponse
    {
        /** @var \SocialiteProviders\Manager\OAuth2\User $discordUser */
        $discordUser = Socialite::driver('discord')->user();

        /** @var ?User $user */
        $user = null;

        $isLoggedIn = user() !== null;

        if (! $isLoggedIn) {
            $user = User::firstWhere('discord_id', $discordUser->id);
        } else {
            $user = user();

            $user->update(['discord_id' => $discordUser->id]);
        }

        if ($user && $discordUser->avatar && ! $user->hasMedia('avatar')) {
            $user->addMediaFromUrl($discordUser->avatar)->toMediaCollection('avatar');
        }

        if (! $isLoggedIn && ! $user) {
            return to_route('auth.login')->with('status', 'No user exists with this Discord account.');
        }

        if (session()->has('connection_oauth_setup')) {
            session()->remove('connection_oauth_setup');

            return to_route('settings.account.connections.index');
        }

        Auth::login($user);

        return to_route('home');
    }
}
