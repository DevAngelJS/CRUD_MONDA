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
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $libros = libro::buscarLibros($buscar, 10);
        if ($request->ajax()) {
            return view('admin.libros.components.indexContent', compact('libros', 'buscar'));
        }
        return view('admin.libros.index', compact('libros', 'buscar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('admin.libros.components.createContent');
        }
        return redirect()->route('admin.libros.index'   );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'año_publicacion' => 'required|date',
            'genero' => 'required|string|max:100',
            'idioma' => 'required|string|max:50',
            'cantidad_stock' => 'required|integer|min:0',
        ]);

        try {
            libro::crearLibro($request->all());

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Libro creado correctamente.'
                ], 200);
            }

            return redirect()
                ->route('admin.libros.index')
                ->with('success', 'Libro creado correctamente.');

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al crear el libro. ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->withErrors(['general' => 'Error al crear el libro.'])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $libro = libro::obtenerPorId($id);
        if (request()->ajax()) {
            return view('admin.libros.components.editContent', compact('libro', 'id'));
        }
        return view('admin.libros.edit', compact('libro', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'titulo' => 'required|string|max:255',
                'autor' => 'required|string|max:255',
                'año_publicacion' => 'required|date',
                'genero' => 'required|string|max:100',
                'idioma' => 'required|string|max:50',
                'cantidad_stock' => 'required|integer|min:0',
            ]);

            libro::actualizarLibro($id, $request->all());

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Libro actualizado correctamente.'
                ], 200);
            }

            return redirect()
                ->route('admin.libros.index')
                ->with('success', 'Libro actualizado correctamente.');

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al actualizar el libro. ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->withErrors(['general' => 'Error al actualizar el libro.'])
                ->withInput();
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
