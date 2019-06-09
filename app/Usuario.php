<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'users';

    protected static function listarUsuariosM($buscar,$filtro)
    {
        if (!$buscar)
            return self::orderBy('id', 'desc')->paginate(5);
        else   
            return self::where($filtro, 'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
    }
    
    protected static function agregarUsuarioM($array)
    {
        $obj = new Usuario();
        $obj->name = $array["nombre"];
        $obj->email = $array["email"];
        $obj->password = $array["clave"];
        $obj->rol = $array["rol"];
        $obj->save();
    }

    protected static function comprobarEmailM($email)
    {
        return self::select('email')->where('email', $email)->first();
    }

    protected static function eliminarUsuarioM($id)
    {
        Usuario::destroy($id);
    }
}
