<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        Gate::define('all-actions', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-posts', function (User $user, Post $post) {
            return $user->id === $post->author->id;
        });
    }
}
