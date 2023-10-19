<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //CRUD Permission
        Gate::define('create', function ($user) {
            return in_array($user->role, ['admin', 'moderator']);
        });

        Gate::define('update', function ($user) {
            return in_array($user->role, ['admin', 'moderator']);
        });

        Gate::define('change-status', function ($user) {
            return in_array($user->role, ['admin']);
        });

        //Menu Permission
        Gate::define('menus', function ($user) {
            return in_array($user->role, ['admin', 'moderator', 'user']);
        });
        Gate::define('reports', function ($user) {
            return in_array($user->role, ['admin', 'moderator', 'user']);
        });
        Gate::define('account', function ($user) {
            return in_array($user->role, ['admin', 'moderator', 'user']);
        });
        Gate::define('management', function ($user) {
            return in_array($user->role, ['admin']);
        });
    }
}
