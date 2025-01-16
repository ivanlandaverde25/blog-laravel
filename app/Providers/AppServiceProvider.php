<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        Post::observe(PostObserver::class);

        // Los gate sirven para mostrar o no pporciones de codigo a un usuario dependiendo de una condicional
        // A los gate se le da un nombre y con este se llaman en las vistas
        // Gate::define('admin', function($user){
        //     return $user->is_admin
        //         ? Response::allow()
        //         : Response::deny('Error authenticating');
        // });

        // Se puede crear una policy para agrupar todos los Gate de un modelo en especifico
        // Gate::define('author', function($user, $post){
        //     return $post->user_id === $user->id
        //     ? Response::allow()
        //     : Response::deny('Ya te la comiste mi pana');
        // });
    }
}
