<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class libro extends Model
{
    protected $table = 'libros';

    protected $fillable = [
        'titulo',
        'autor',
        'año_publicacion',
        'genero',
        'idioma',
        'cantidad_stock',
        'estatus',
    ];

    public static function buscarLibros($buscar = null, $cantidad = 10)
{
    $query = DB::table('libros')->where('estatus', 1);


    if ($buscar) {
        
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('autor', 'like', "%{$buscar}%")
                  ->orWhere('genero', 'like', "%{$buscar}%")
                  ->orWhere('idioma', 'like', "%{$buscar}%");
            });

    }

    return $query->paginate($cantidad);
}


    public static function obtenerPorId($id)
    {
        return DB::table('libros')->where('id', $id)->first();
    }

    public static function crearLibro($data)
    {
        return DB::table('libros')->insert([
            'titulo' => $data['titulo'],
            'autor' => $data['autor'],
            'año_publicacion' => $data['año_publicacion'],
            'genero' => $data['genero'],
            'idioma' => $data['idioma'],
            'cantidad_stock' => $data['cantidad_stock'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public static function actualizarLibro($id, $data)
    {
        return DB::table('libros')->where('id', $id)->update([
            'titulo' => $data['titulo'],
            'autor' => $data['autor'],
            'año_publicacion' => $data['año_publicacion'],
            'genero' => $data['genero'],
            'idioma' => $data['idioma'],
            'cantidad_stock' => $data['cantidad_stock'],
            'updated_at' => Carbon::now(),
        ]);
    }

    public static function eliminarLibro($id)
    {
        return DB::table('libros')->where('id', $id)->delete();
    }

    
    /** @use HasFactory<\Database\Factories\LibroFactory> */
    use HasFactory;
}
