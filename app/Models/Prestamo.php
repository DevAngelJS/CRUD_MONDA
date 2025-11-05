<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Prestamo extends Model
{
    protected $table = 'prestamo_libro';

    protected $fillable =[
        'usuario_id',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
        'estatus',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    //funciones

    public static function obtenerTodos(){
        //recuperamos los estudiantes a prestar(en este caso los usuarios de ejemplo)
        $estudiantes = User::select('id','name')->get();
        //recuperamos los libros a prestar
        $libros = libro::select('id','titulo', 'autor')->get();

        return [$estudiantes, $libros];
    }

    public static function showData($buscar = null)
    {
        $data = DB::table('prestamo_libro')
        ->join('users', 'prestamo_libro.usuario_id', '=', 'users.id')
        ->join('detalle_prestamo', 'prestamo_libro.id', '=', 'detalle_prestamo.prestamo_id')
        ->select('prestamo_libro.id', 'users.name', 'detalle_prestamo.libro_id', 'detalle_prestamo.cantidad', 'prestamo_libro.fecha_inicio', 'prestamo_libro.fecha_fin', 'prestamo_libro.descripcion', 'prestamo_libro.estatus')
        ->where('prestamo_libro.estatus', 1);

        //Buscamos por nombre
        if($buscar){
            $data->where('users.name', 'like', "%{$buscar}%");
        }   

        return $data->paginate(10);
    }

    public static function guardarPrestamo($validate){
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

            return [true, 'Prestamo guardado correctamente'];
        }catch(Exception $e){
            DB::rollBack();
            
            return [false, 'Error al guardar el prestamo'. $e->getMessage()];
        }
    }

    public static function updatePrestamo($validate, $id)
    {
        try {
            DB::beginTransaction();

            // 1️⃣ Actualizamos el préstamo principal
            DB::table('prestamo_libro')
                ->where('id', $id)
                ->update([
                    'usuario_id'    => $validate['estudiante_id'],
                    'fecha_inicio'  => $validate['fecha_inicio'],
                    'fecha_fin'     => $validate['fecha_fin'],
                    'descripcion'   => $validate['descripcion'] ?? "Sin Descripción",
                ]);

            // 2️⃣ Obtenemos los detalles actuales
            $detallesActuales = DB::table('detalle_prestamo')
                ->where('prestamo_id', $id)
                ->pluck('id', 'libro_id') // [libro_id => detalle_id]
                ->toArray();

            // 3️⃣ Recorremos los nuevos libros enviados
            $librosNuevos = $validate['libros'];
            $librosNuevosIds = [];

            foreach ($librosNuevos as $libroData) {
                $libro_id = $libroData['libro_id'];
                $cantidad = $libroData['cantidad'];
                $librosNuevosIds[] = $libro_id;

                // Si ya existe, actualizamos cantidad
                if (isset($detallesActuales[$libro_id])) {
                    DB::table('detalle_prestamo')
                        ->where('id', $detallesActuales[$libro_id])
                        ->update(['cantidad' => $cantidad]);
                } else {
                    // Si no existe, insertamos nuevo detalle
                    DB::table('detalle_prestamo')->insert([
                        'prestamo_id' => $id,
                        'libro_id'    => $libro_id,
                        'cantidad'    => $cantidad,
                    ]);
                }
            }

            // 4️⃣ Eliminamos los libros que ya no están en la nueva lista
            DB::table('detalle_prestamo')
                ->where('prestamo_id', $id)
                ->whereNotIn('libro_id', $librosNuevosIds)
                ->delete();

            DB::commit();

            return [true, 'Préstamo actualizado correctamente'];
        } catch (Exception $e) {
            DB::rollBack();
            return [false, 'Error al actualizar el préstamo: ' . $e->getMessage()];
        }
    }


}
