<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()
                    ->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all(); 
        $request->validate([
            'name' => 'required|string|min:2|max:255|unique:roles,name',
            'permissions' => 'nullable|array'
        ]);


        $rol = Role::create([
            'name' => $request->name,
        ]);

        $rol->permissions()->sync($request->permissions);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol creado con exito',
            'text' => 'El rol ha sido creado exitosamente.'
        ]);

        return redirect()->route('admin.roles.edit', $rol);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = $role->permissions->pluck('id')->toArray();

        // return $permissions;
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required|string|min:2|max:255|unique:roles,name,'.$role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->permissions()->sync($request->permissions);

        $role->update($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Edicion exitosa',
            'text' => 'El rol se edito exitosamente'
        ]);

        return redirect()->route('admin.roles.edit', $role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminacion exitosa',
            'text' => 'El rol se elimino exitosamente'
        ]);

        return redirect()->route('admin.roles.index');
    }
}
