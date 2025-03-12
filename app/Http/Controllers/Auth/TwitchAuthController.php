<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\FrontendController;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpFoundationRedirectResponse;

class TwitchAuthController extends FrontendController
{
    public function index(): HttpFoundationRedirectResponse
    {
        if (user() && user()->twitch_id) {
            session()->put('connection_oauth_setup', true);
        }

        return Socialite::driver('twitch')->redirect();
    }

    public function store(): RedirectResponse
    {
        /** @var \SocialiteProviders\Manager\OAuth2\User $twitchUser */
        $twitchUser = Socialite::driver('twitch')->user();

        /** @var ?User $user */
        $user = null;

        $isLoggedIn = user() !== null;

        if (! $isLoggedIn) {
            $user = User::firstWhere('twitch_id', $twitchUser->id);
        } else {
            $user = user();

            $user->update(['twitch_id' => $twitchUser->id]);
        }

        if ($user && $twitchUser->avatar && ! $user->hasMedia('avatar')) {
            $user->addMediaFromUrl($twitchUser->avatar)->toMediaCollection('avatar');
        }

        if (! $isLoggedIn && ! $user) {
            return to_route('auth.login')->with('status', 'No user exists with this Twitch account.');
        }

        if (session()->has('connection_oauth_setup')) {
            session()->remove('connection_oauth_setup');

            return to_route('settings.account.connections.index');
        }

        Auth::login($user);

        return to_route('home');
    }
}
