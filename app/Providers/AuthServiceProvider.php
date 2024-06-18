<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('create', function (User $user) {
            return $user->role === 'admin' || $user->role === 'moderator';
        });

        Gate::define('view', function (User $user) {
            return true;
        });

        Gate::define('update', function (User $user, $model) {
            return $user->role === 'admin' || ($user->role === 'moderator' && $user->id === $model->created_by) || $user->id === $model->created_by;
        });

        Gate::define('delete', function (User $user, $model) {
            return $user->role === 'admin' || ($user->role === 'moderator' && $user->id === $model->created_by);
        });

        Gate::define('restore', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
