<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const DASHBOARD = '/dashboard';

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::middleware(['web', 'auth', 'admin'])
            ->prefix('dashboard')
            ->as('dashboard.')
            ->group(base_path('routes/dashboard.php'));

    }
}
