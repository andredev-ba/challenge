<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin', function () {
            $payload = json_decode(Auth::token());

            $realmAccess = $payload->realm_access ?? null;

            $roles = $realmAccess->roles ?? [];

            if (in_array('admin', $roles) || Auth::user()->isTest) return true;

            return false;
        });

        Gate::define('user', function () {
            $payload = json_decode(Auth::token());

            $realmAccess = $payload->realm_access ?? null;

            $roles = $realmAccess->roles ?? [];

            if (in_array('user', $roles) || Auth::user()->isTest) return true;

            return false;
        });
    }
}
