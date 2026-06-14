<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\OrganisationRole;
use App\Models\Organisation;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Fortify;

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
        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Model::shouldBeStrict();

        URL::forceScheme('https');

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->max(255)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );

        Gate::before(function (User $user, string $ability): ?true {
            $lanListOrganisation = cache(
                'lanListOrganisationId',
                Organisation::query()->firstWhere('name', 'LanList')?->id,
            );

            if (! $user->organisations()->where('organisations.id', $lanListOrganisation)->exists()) {
                return null;
            }
            if ($user->hasRole(OrganisationRole::Owner)) {
                return true;
            }

            return null;
        });

        Authenticate::redirectUsing(fn (): string => route('login'));
        ResetPassword::createUrlUsing(fn (mixed $user, string $token): string => route('password.reset', ['token' => $token]));

        $this->configureRateLimiting();

        Vite::prefetch(concurrency: 3);
        Vite::useAggressivePrefetching();
        Vite::useIntegrityKey('integrity');
    }

    private function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request): Limit {
            /** @var User|null $user */
            $user = optional($request->user());

            return Limit::perMinute(120)->by($user?->id ?: $request->ip());
        });

        RateLimiter::for('two-factor', fn (Request $request) => Limit::perMinute(5)->by($request->session()->get('login.id')));

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId()).'|'.$request->ip(),
            );
        });
    }
}
