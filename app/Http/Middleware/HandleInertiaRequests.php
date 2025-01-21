<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    public function handle(Request $request, Closure $next)
    {
        Vite::useIntegrityKey('integrity');

        $response = parent::handle($request, $next);

        return $response;
    }

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return Vite::manifestHash();
    }

    /**
     * Define the props that are shared by default.
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), self::sharable($request));
    }

    /**
     * Share information between HandleInertiaRequests and Handler classes.
     */
    public static function sharable(Request $request): array
    {
        return [
            'location' => $request->url(),
            'notification' => session('notification'),
            'user' => $request->user() ? UserResource::make($request->user()) : null,
        ];
    }
}
