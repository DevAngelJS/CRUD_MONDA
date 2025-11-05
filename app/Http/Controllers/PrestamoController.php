<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Prestamo;
use App\Models\libro;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $data = Prestamo::showData($buscar);
        if($request->ajax()){
            return view('admin.prestamo.indexContent', compact('data'));
        }

        return view('admin.prestamo.index', compact('data'));
    }



    public function create(Request $request)
    {
        [$estudiantes, $libros] = Prestamo::obtenerTodos();

        if($request->ajax()){
            return view('admin.prestamo.createContent', compact('estudiantes', 'libros'));
        }

        return redirect()->route('admin.prestamo.index');
    }

    public function guardar(Request $request)
    {
        $validate = $request->validate([
            'estudiante_id' => 'required|exists:users,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'descripcion' => 'nullable|string|max:100',
            'libros' => 'required|array|min:1',
            'libros.*.libro_id' => 'required|exists:libros,id',
            'libros.*.cantidad' => 'required|integer|min:1',
        ], [
            'estudiante_id.required' => 'El campo estudiante es obligatorio',
            'estudiante_id.exists' => 'El estudiante seleccionado no es válido',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria',
            'fecha_inicio.after_or_equal' => 'La fecha de inicio no puede ser anterior a hoy',
            'fecha_fin.required' => 'La fecha de fin es obligatoria',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio',
            'descripcion.max' => 'La descripción no debe exceder los 100 caracteres',
            'libros.required' => 'Debe agregar al menos un libro',
            'libros.min' => 'Debe agregar al menos un libro',
            'libros.*.libro_id.required' => 'Debe seleccionar un libro',
            'libros.*.cantidad.required' => 'La cantidad es obligatoria',
            'libros.*.cantidad.min' => 'La cantidad mínima es 1',
        ]);

        if($validate){
            //Ejecutamos la funcion
            [$isPass , $message] = Prestamo::guardarPrestamo($validate);

            if($isPass){
                return response()->json([
                    'status' => 'success',
                    'message' => $message
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => $message
                ]);
            }
        }
        
    }

    public function edit($id)
    {
        \Log::info('Edit method called with ID: ' . $id);
        
        [$estudiantes, $libros] = Prestamo::obtenerTodos();
        \Log::info('Estudiantes: ' . $estudiantes->count());
        \Log::info('Libros: ' . $libros->count());
        
        try {
            $data = Prestamo::find($id);
            \Log::info('Préstamo encontrado: ' . ($data ? 'Sí' : 'No'));
        } catch (\Exception $e) {
            \Log::error('Error al buscar préstamo: ' . $e->getMessage());
            throw $e;
        }
        
        if (!$data) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Préstamo no encontrado'], 404);
            }
            return redirect()->route('admin.prestamo.index')->with('error', 'Préstamo no encontrado');
        }

        $detalleLibros = DB::table('detalle_prestamo')
        ->join('libros', 'detalle_prestamo.libro_id', '=', 'libros.id')
        ->select('detalle_prestamo.*', 'libros.titulo', 'libros.autor')
        ->where('detalle_prestamo.prestamo_id', $id)
        ->get();

        if (request()->ajax()) {
            return view('admin.prestamo.editContent', compact('estudiantes', 'libros', 'data', 'detalleLibros'));
        }
        
        return redirect()->route('admin.prestamo.index');
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'estudiante_id' => 'required|exists:users,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'descripcion' => 'nullable|string|max:100',
            'libros' => 'required|array|min:1',
            'libros.*.libro_id' => 'required|exists:libros,id',
            'libros.*.cantidad' => 'required|integer|min:1',
        ]);

        if($validate){
            //Ejecutamos la funcion
            [$isPass , $message] = Prestamo::updatePrestamo($validate, $id);

            if($isPass){
                return response()->json([
                    'status' => 'success',
                    'message' => $message
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => $message
                ]);
            }
        }

    }

    public function destroy($id)
    {
        $prestamo = Prestamo::find($id);
        if ($prestamo) {
            $prestamo->update([
                'estatus' => 0,
            ]);
            return redirect()->route('admin.prestamo.index')->with('success', 'Préstamo eliminado correctamente.');
        }

        return redirect()->route('admin.prestamo.index')->with('error', 'Préstamo no encontrado.');
    }
}
