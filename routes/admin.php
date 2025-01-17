<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('admin.dashboard');
})
->middleware('can:Ver Dashboard')
->name('dashboard');

Route::resource('/categories', CategoryController::class)
    ->parameters(['categories' => 'category'])
    ->names('categories')
    ->middleware('can:Gestionar categorias');

Route::resource('/posts', PostController::class)
    ->parameters(['posts' => 'post'])
    ->names('posts')
    ->middleware('can:Gestionar posts');

// Rutas para los roles
Route::resource('/roles', RoleController::class)
    ->parameters(['roles' => 'role'])
    ->names('roles')
    ->middleware('can:Gestion de roles');

// Rutas para los permisos
Route::resource('/permissions', PermissionController::class)
    ->parameters(['permissions' => 'permission'])
    ->names('permissions')
    ->middleware('can:Gestion de permisos');

// Rutas para los usuarios
Route::resource('/users', UserController::class)
    ->parameters(['users' => 'user'])
    ->names('users')
    ->middleware('can:Gestionar Usuarios');

Route::get('/prueba', function(){
    return 'hola';
});