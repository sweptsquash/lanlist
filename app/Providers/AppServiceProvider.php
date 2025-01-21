<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Date::use(CarbonImmutable::class);

        Password::defaults(function () {
            if (app()->isProduction()) {
                return Password::min(12)
                    ->mixedCase()
                    ->letters()
                    ->numbers();
            } else {
                return Password::min(8);
            }
        });

        Authenticate::redirectUsing(function () {
            return route('auth.login');
        });

        $this->subscribeEvents();
    }

    private function subscribeEvents(): void
    {
        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('discord', \SocialiteProviders\Discord\Provider::class);
        });

        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('facebook', \SocialiteProviders\Facebook\Provider::class);
        });

        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('google', \SocialiteProviders\Google\Provider::class);
        });
    }
}
