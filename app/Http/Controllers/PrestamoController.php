<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\libro;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class PrestamoController extends Controller
{
    public function index()
    {
        //recuperamos los estudiantes a prestar(en este caso los usuarios de ejemplo)
        $estudiantes = User::select('id','name')->get();
        //recuperamos los libros a prestar
        $libros = libro::select('id','titulo', 'autor')->get();

        return view('admin.prestamo.index', compact('estudiantes', 'libros'));
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
            try{
                DB::beginTransaction();
    
                $prestamo_id = DB::table('prestamo_libro')->insertGetId([
                    'usuario_id' => $validate['estudiante_id'],
                    'fecha_inicio' => $validate['fecha_inicio'],
                    'fecha_fin' => $validate['fecha_fin'],
                    'descripcion' => $validate['descripcion'] ?? "Sin Descripcion",
                    'estatus' => 1,
                ]);
                
                //recuperamos el array de libros
                $libros_colletion = $validate['libros'];
    
                foreach ($libros_colletion as $libroData) {
                    //Inserta los libros en la tabla detalle_prestamo
                    DB::table('detalle_prestamo')->insert([
                        'prestamo_id' => $prestamo_id,
                        'libro_id' => $libroData['libro_id'],
                        'cantidad' => $libroData['cantidad'],
                    ]);
    
                }
    
                DB::commit();
    
                return redirect()->route('admin.prestamos.index')->with('success', 'Prestamo guardado correctamente.');
            }catch(Exception $e){
                DB::rollBack();
                return redirect()->route('admin.prestamos.index')->with('error', 'Error al guardar el prestamo.'.$e->getMessage());
            }
        }
        
    }
}
