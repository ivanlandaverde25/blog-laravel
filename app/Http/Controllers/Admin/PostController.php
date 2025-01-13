<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest('id')
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
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $tags = [];
        // return $request->all();
        $request->validate([
            'title' => 'required|string|min:2|max:255',
            'slug' => 'required|string|min:2|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'required|integer|exists:categories,id',
            'excerpt' =>  $request->published ? 'required|string|min:2|max:500' : 'nullable|string|min:2|max:500',
            'body' => $request->published ? 'required|string|min:2|max:2500' : 'nullable|string|min:2|max:2500',
            'published' => 'required|boolean',
            'tags' => 'nullable|array',
        ]);

        foreach ($request->tags ?? [] as $name) {
            $tag = Tag::firstOrCreate([
                'name' => $name,
            ]);

            $tags[] = $tag->id;
        }

        $post->tags()->sync($tags);
        $post->update($request->all());

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
