<?php

namespace App\Extensions;

use Illuminate\Support\Facades\Route;

class RoutingExtension
{
    public static function registerMacros(): void
    {
        // Registra el macro para whereSlug
        if (!Route::hasMacro('whereSlug')) {
            Route::macro('whereSlug', function ($param) {
                /** @var \Illuminate\Routing\Route $this */
                return $this->where($param, '[a-zA-Z0-9-_]+');
            });
        }
    }
}
