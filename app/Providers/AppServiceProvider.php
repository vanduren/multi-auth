<?php

namespace App\Providers;

use App\Models\User;
use Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('gate-superadmin', function (User $user) {
            return $user->role === '1';
        });
        Gate::define('gate-admin', function (User $user) {
            // dd($user->role);
            return $user->role === '2';
        });
        Gate::define('gate-user', function (User $user) {
            return $user->role === '3';
        });

    }
}
