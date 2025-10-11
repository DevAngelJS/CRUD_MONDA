<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibroController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/libros', [App\Http\Controllers\LibroController::class, 'index'])->name('admin.libros.index')->middleware('auth');
Route::get('/admin/libros/create', [App\Http\Controllers\LibroController::class, 'create'])->name('admin.libros.create')->middleware('auth');
Route::post('/admin/libros', [App\Http\Controllers\LibroController::class, 'store'])->name('admin.libros.store')->middleware('auth');
Route::get('/admin/libros/{id}/edit', [App\Http\Controllers\LibroController::class, 'edit'])->name('admin.libros.edit')->middleware('auth');
Route::post('/admin/libros/{id}', [App\Http\Controllers\LibroController::class, 'update'])->name('admin.libros.update')->middleware('auth');
Route::delete('/admin/libros/{id}', [App\Http\Controllers\LibroController::class, 'destroy'])->name('admin.libros.destroy')->middleware('auth');
Route::get('/admin/usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('admin.libros.usuarios.index')->middleware('auth');
Route::get('/admin/usuarios/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.libros.usuarios.edit')->middleware('auth');
Route::post('/admin/usuarios/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.libros.usuarios.update')->middleware('auth');

// Route::get('/admin/contraseña', [App\Http\Controllers\PasswordController::class, 'index'])->name('admin.libros.contraseña.index')->middleware('auth');
Route::get('/admin/contraseña/{id}/edit', [App\Http\Controllers\PasswordController::class, 'edit'])->name('admin.libros.contraseña.edit')->middleware('auth');
Route::post('/admin/contraseña/{id}', [App\Http\Controllers\PasswordController::class, 'update'])->name('admin.libros.contraseña.update')->middleware('auth');


