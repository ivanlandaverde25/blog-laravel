<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostObserver
{
    // El metodo creating sirve para ejecutar una porcion de codigo antes de realizar las acciones
    public function creating(Post $post){
        if(!app()->runningInConsole()){
            $post->user_id = Auth::id();
        }
    }

    // Para ejecutar procesos despues de una accion, se debe utilizar el metodo created
    public function updating(Post $post){
        if($post->published && !$post->published_at){
            $post->published_at = now();
        }
    }
}
