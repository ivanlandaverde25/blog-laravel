<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // return $user->roles;
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|min:5|max:255|unique:users,email,'.$user->id,
            'password' => $request->password ? 'required|min:8|max:255|confirmed' : 'nullable',
            'roles' => 'nullable|array',
        ]);

        // $user->update($request->all());

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        $user->save();

        session()->flash('swal', [
            'icon' =>'success',
            'title' => 'Edicion exitosa',
            'text' => 'El usuario se edito exitosamente'
        ]);

        return redirect()->route('admin.users.edit', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
