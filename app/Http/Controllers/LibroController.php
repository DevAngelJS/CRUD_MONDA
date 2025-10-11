<?php

namespace App\Http\Controllers;

use App\Models\libro;
use Illuminate\Http\Request;
use Exception;


class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buscar = request()->input('buscar');
        $libros = libro::buscarLibros($buscar, 10);
        return view('admin.libros.index', compact('libros', 'buscar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.libros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'año_publicacion' => 'required|date',
            'genero' => 'required|string|max:100',
            'idioma' => 'required|string|max:50',
            'cantidad_stock' => 'required|integer|min:0',
        ]);
        try{
            libro::crearLibro($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Libro creado correctamente.',
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el libro.'. $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $libro = libro::obtenerPorId($id);
        return view('admin.libros.edit', compact('libro', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            // Validar los datos del formulario
            $request->validate([
                'titulo' => 'required|string|max:255',
                'autor' => 'required|string|max:255',
                'año_publicacion' => 'required|date',
                'genero' => 'required|string|max:100',
                'idioma' => 'required|string|max:50',
                'cantidad_stock' => 'required|integer|min:0',
            ]);
    
            libro::actualizarLibro($id, $request->all());
    
            return response()->json([
                'success' => true,
                'message' => 'Libro actualizado correctamente.',
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el libro.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        $libro = libro::find($id);
        if ($libro) {
            $libro->update([
                'estatus' => 0,
            ]);
            return redirect()->route('admin.libros.index')->with('success', 'Libro eliminado correctamente.');
        }

        return redirect()->route('admin.libros.index')->with('error', 'Libro no encontrado.');
    }

}
