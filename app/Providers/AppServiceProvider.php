<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\UserEventSubscriber;
use App\Listeners\UserRegisterSubscriber;
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
            }

            return Password::min(8);

        });

        Authenticate::redirectUsing(function () {
            return route('auth.login');
        });

        $this->subscribeEvents();
    }

    private function subscribeEvents(): void
    {
        Event::subscribe(UserRegisterSubscriber::class);
        Event::subscribe(UserEventSubscriber::class);

        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('discord', \SocialiteProviders\Discord\Provider::class);
        });

        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('twitch', \SocialiteProviders\Twitch\Provider::class);
        });
    }
}
