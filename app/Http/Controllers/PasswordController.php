<?php

namespace App\Http\Controllers;

use App\Models\Password;
use App\Models\User;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    //

        public function index()
    {
        return view('admin.libros.contraseña.index');
    }



    public function edit($id)
    {
        $contraseña = User::obtenerPorIdContraseña($id);
        return view('admin.libros.contraseña.edit', compact('contraseña'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::actualizarContraseñaUsuario($id, $validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'La contraseña se actualizó correctamente.',
            ]);
        }

        return redirect()->route('admin.libros.usuarios.index')->with('success', 'contraseña actualizada correctamente.');
    }
}
