<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){

    session()->flash('swal', [
        'type' => "success",
        'title' => "Welcome",
        'text' => "Has initialized"
    ]);

    return view('admin.dashboard');
})->name('dashboard');

Route::resource('/categories', CategoryController::class)
    ->parameters(['categories' => 'category'])
    ->names('categories');

Route::resource('/posts', PostController::class)
    ->parameters(['posts' => 'post'])
    ->names('posts');

// Rutas para los roles
Route::resource('/roles', RoleController::class)
    ->parameters(['roles' => 'role'])
    ->names('roles');

// Rutas para los permisos
Route::resource('/permissions', PermissionController::class)
    ->parameters(['permissions' => 'permission'])
    ->names('permissions');