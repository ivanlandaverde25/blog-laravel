<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
                    ->latest('id')
                    ->paginate(5);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'slug' => 'required|string|min:2|max:255|unique:posts,slug',
        ]);

        $post = Post::create($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Post creado',
            'text' => 'Post creado exitosamente'
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // if(!Gate::allows('author', $post)){
        //     abort(403, 'You are not allowed to edit.');
        // }

        // Es mas facil validar con el metodo authorize
        Gate::authorize('author', $post);
        
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // return $request->all();
        $tags = [];
        $data = $request->all();
        
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'slug' => 'required|string|min:2|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'required|integer|exists:categories,id',
            'excerpt' =>  $request->published ? 'required|string|min:2|max:500' : 'nullable|string|min:2|max:500',
            'body' => $request->published ? 'required|string|min:2|max:2500' : 'nullable|string|min:2|max:2500',
            'published' => 'required|boolean',
            'tags' => 'nullable|array',
            'post_image' => 'nullable|image|max:1024',
        ]);

        // Verificar si existen todos los tags ingresados en el select2
        foreach ($request->tags ?? [] as $name) {

            // El metodo firstOrCreate sirve para consultar si el tag existe, en el caso que no se crea en base
            $tag = Tag::firstOrCreate([
                'name' => $name,
            ]);

            // Se retornan los id de los tags a un arreglo, los cuales son los que se van asociar al post
            $tags[] = $tag->id;
        }

        // Se sincronizan todos los tags con el post
        $post->tags()->sync($tags);

        // Validar si existe una imagen en el envio
        if ($request->file('post_image')){
            
            // Si existe una imagen antes de subir una nueva, eliminar la imagen actual
            if($post->image_path){
                Storage::delete($post->image_path);
            }

            // Generar nombre del archivo
            $file_name = $request->slug . '.' . $request->file('post_image')->getClientOriginalExtension();

            // Almacenar la url de la nueva imagen para almacenarla en base
            // $data['image_path'] = Storage::putFileAs('posts', $request->post_image, $file_name);

            // Otra forma de guardar archivos
            $data['image_path'] = $request->file('post_image')->storeAs('posts', $file_name);
        }

        // Enviar todos los datos del post a actualizar a base
        $post->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Edicion exitosa!',
            'text' => 'Se ha editado el registro exitosamente!',
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminacion exitosa!',
            'text' => 'El registro se ha eliminado exitosamente',
        ]);

        return redirect()->route('admin.posts.index');
    }
}
