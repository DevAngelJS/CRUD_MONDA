<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
