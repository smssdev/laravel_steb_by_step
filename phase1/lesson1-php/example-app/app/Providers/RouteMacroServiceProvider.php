<?php

namespace App\Providers;

use App\Extensions\RoutingExtension;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteMacroServiceProvider extends ServiceProvider
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
        Route::pattern('id', '[0-9]+');
        RoutingExtension::registerMacros();

    }
}
