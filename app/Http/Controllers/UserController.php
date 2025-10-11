<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function index()
    {
        return view('admin.libros.usuarios.index');
    }



    public function edit($id)
    {
        $usuarios = User::obtenerPorId($id);
        return view('admin.libros.usuarios.edit', compact('usuarios'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',

        ]);

        User::actualizarUsuario($id, $request->all());

        return redirect()->route('admin.libros.usuarios.index')->with('success', 'usuario actualizado correctamente.');
    }

}
