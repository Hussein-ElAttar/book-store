<?php

namespace App\Providers;

use App\Src\Jwt\Manager;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;
use Tymon\JWTAuth\Manager as TymonManager;
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
        $this->registerManager();
    }

    protected function registerManager()
    {
        $this->app->singleton('tymon.jwt.manager', function ($app) {
            $instance = new Manager(
                $app['tymon.jwt.provider.jwt'],
                $app['tymon.jwt.blacklist'],
                $app['tymon.jwt.payload.factory']
            );

            return $instance->setBlacklistEnabled((bool) $this->config('blacklist_enabled'))
                            ->setPersistentClaims($this->config('persistent_claims'));
        });
    }
}