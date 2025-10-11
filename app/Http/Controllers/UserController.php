<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    //

    public function index()
    {
        $usuarios = User::obtenerTodos();
        return view('admin.libros.usuarios.index', compact('usuarios'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Crear usuario (Eloquent aplica hashing por el cast 'password' => 'hashed')
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'El usuario se creó correctamente.',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
        }

        return redirect()->route('admin.libros.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }



    public function edit($id)
    {
        $usuarios = User::obtenerPorId($id);
        return view('admin.libros.usuarios.edit', compact('usuarios'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
        ]);

        User::actualizarUsuario($id, $validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'El usuario se actualizó correctamente.',
            ]);
        }

        return redirect()->route('admin.libros.usuarios.index')->with('success', 'usuario actualizado correctamente.');
    }

}
