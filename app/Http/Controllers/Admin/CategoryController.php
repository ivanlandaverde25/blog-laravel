<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest('id')
                                ->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255'
        ]);

        Category::create($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Categoria registrada.',
            'text' => 'La categoria se agrego con exito.'
        ]);
        return redirect()->route('admin.categories.index')->with([
            'sw' => '',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255'
        ]);

        $category->update($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Categoria actualizada',
            'text' => 'La categoria se actulizó exitosamente'
        ]);

        return redirect()->route('admin.categories.edit', compact('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Validar primero si existen post que ya pertnezcan a la categoria que se desea eliminar
        $posts = Post::where('id', $category->id)->exists();

        if($posts){
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error al eliminar la categoria',
                'text' => 'La categoria no puede ser eliminada debido a que existen posts asociados a ella',
            ]);

            return redirect()->back();
        } else {
            $category->delete();
    
            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Eliminaci[on exitosa',
                'text' => 'La categoria se elimino con exito'
            ]);

            return redirect()->route('admin.categories.index');
        }
        

    }
}
