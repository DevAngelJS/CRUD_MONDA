<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibrosController;

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

/* USUARIOS */
Route::get('/admin/usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('admin.libros.usuarios.index')->middleware('auth');
Route::post('/admin/usuarios', [App\Http\Controllers\UserController::class, 'store'])->name('admin.libros.usuarios.store')->middleware('auth');
Route::get('/admin/usuarios/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.libros.usuarios.edit')->middleware('auth');
Route::post('/admin/usuarios/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.libros.usuarios.update')->middleware('auth');

// Route::get('/admin/contraseña', [App\Http\Controllers\UserController::class, 'index'])->name('admin.libros.contraseña.index')->middleware('auth');
Route::get('/admin/contraseña/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.libros.contraseña.edit')->middleware('auth');
Route::post('/admin/contraseña/{id}', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('admin.libros.contraseña.update')->middleware('auth');

// Perfil usuario autenticado
Route::get('/admin/usuarios/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('admin.libros.usuarios.perfil');

//Prestamos de libros

Route::prefix('admin/prestamo')->group(function () {
    Route::get('/', [App\Http\Controllers\PrestamoController::class, 'index'])->name('admin.prestamo.index');
    Route::post('/', [App\Http\Controllers\PrestamoController::class, 'guardar'])->name('admin.prestamo.store');
})->middleware('auth');

Route::prefix('admin/prestamos')->group(function () {
    Route::get('/', [App\Http\Controllers\PrestamosController::class, 'index'])->name('admin.prestamos.index');
    Route::post('/', [App\Http\Controllers\PrestamosController::class, 'guardar'])->name('admin.prestamos.store');
})->middleware('auth');