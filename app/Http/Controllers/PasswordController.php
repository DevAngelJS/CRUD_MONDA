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
        $request->validate([
            'password' => 'required',


        ]);

        User::actualizarContraseñaUsuario($id, $request->all());

        return redirect()->route('admin.libros.usuarios.index')->with('success', 'contraseña actualizada correctamente.');
    }
}
