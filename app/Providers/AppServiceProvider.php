<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Classes\Practice as prac;
use Illuminate\Support\Facades\View;
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
        $this->app->singleton('the-practice', function () {
            return new prac;
        });
        //The lines below make the thePractice class and the direct practice model available to all views
        View::composer(['*'], function ($view) {
            $view->with('thePractice', $this->app->make('the-practice'));
            $view->with('practice', $this->app->make('the-practice')->model);
        });

        $this->bootAuth();
    }
    public function bootAuth(): void
    {
        //

        Gate::define('service-nl', function (User $user) {
            return app('the-practice')->getService('nl');
        });

        Gate::define('service-ws', function (User $user) {
            return app('the-practice')->getService('ws');
        });

        Gate::define('service-reputation', function (User $user) {
            return app('the-practice')->getService('repm');
        });

        Gate::define('superadmin', function () {
            return auth()->user()->isSuperAdmin();
        });

        Gate::define('use-feed', function (User $user) {
            return app('the-practice')->getService('nl') and app('the-practice')->feed_practice->IsFeedAccessible;
        });

//        Gate::define('viewPulse', function ($user) {
//            $specialPermission = json_decode(config('settings.special_permission'), true);
//
//            return in_array($user->email, $specialPermission);
//        });
    }
}
