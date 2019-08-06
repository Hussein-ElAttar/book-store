<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class JWTLaravelServiceProvider extends LaravelServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->middlewareAliases['jwt.auth'] = \App\Http\Middleware\JWTAuthenticate::class;
        $this->middlewareAliases['jwt.refresh'] = \App\Http\Middleware\JWTRefresh::class;
    }
}