<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        Passport::enablePasswordGrant();

        $this->registerPolicies();

        Passport::ignoreRoutes();

        // Define Passport scopes
        Passport::tokensCan([
            'user' => 'Access user-specific resources',
            'admin' => 'Access admin-specific resources',
        ]);

        // Default scope
        Passport::setDefaultScope([
            'user',
        ]);
    }
}
