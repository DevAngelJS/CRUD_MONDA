<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'perfil',
        'name',
        'email',
        'password',
    ];

    public static function obtenerTodos($cantidad = 10)
    {
        return DB::table('users')->paginate($cantidad);
    }


        public static function obtenerPorId($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }


        public static function actualizarUsuario($id, $data)
    {
        return DB::table('users')->where('id', $id)->update([
            'perfil' => $data['perfil'],
            'name' => $data['name'],
            'email' => $data['email'],
            'updated_at' => Carbon::now(),
        ]);
    }

            public static function obtenerPorIdContraseña($id)
    {
        return DB::table('users')->where('id', $id)->first();
    }


        public static function actualizarContraseñaUsuario($id, $data)
    {
        return DB::table('users')->where('id', $id)->update([
            // 'password' => $data['password'],
            'password' => Hash::make($data['password']),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
