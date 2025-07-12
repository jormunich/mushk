<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Blade::directive('admin', function () {
            return "<?php if (auth()->user()->is_admin) { ?>";
        });

        Blade::directive('elseAdmin', function () {
            return "<?php } else { ?>";
        });

        Blade::directive('endAdmin', function () {
            return "<?php } ?>";
        });
    }
}
