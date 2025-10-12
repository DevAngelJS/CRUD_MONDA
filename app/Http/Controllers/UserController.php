<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function index()
    {
        $perPage = request()->get('perPage', 10);
        $usuarios = User::obtenerTodos($perPage);
        return view('admin.libros.usuarios.index', compact('usuarios', 'perPage'));
    }

    public function show($id)
    {
        $perPage = $request->get('perPage', 10);
        $buscar = $request->get('buscar'); 
    
        $usuario = User::buscarUsuarios($buscar, $perPage);
        return view('admin.libros.usuarios.perfil', compact('usuario', 'perPage', 'buscar'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'perfil' => 'required|string|in:administrador,estudiante,bibliotecario',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Crear usuario (Eloquent aplica hashing por el cast 'password' => 'hashed')
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'perfil' => $validated['perfil'],
            'password' => $validated['password'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'El usuario se creó correctamente.',
                'data' => [
                    'id' => $user->id,
                    'perfil' => $user->perfil,
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
            'perfil' => 'required|string|in:administrador,estudiante,bibliotecario',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $id,
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

    public function updatePassword(Request $request, $id)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Usar tu método estático que ya existe
        $user = User::obtenerPorIdContraseña($id);
        
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado.',
                ], 404);
            }
            return redirect()->route('admin.libros.usuarios.index')->with('error', 'Usuario no encontrado.');
        }

        // Verificar que la contraseña actual sea correcta
        if (!Hash::check($validated['current_password'], $user->password)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'La contraseña actual no es correcta.',
                ], 422);
            }
            return redirect()->back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        // Actualizar la contraseña
        User::actualizarContraseñaUsuario($id, $validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente.',
            ]);
        }

        return redirect()->route('admin.libros.usuarios.index')->with('success', 'Contraseña actualizada correctamente.');
}

}