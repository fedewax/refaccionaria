<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'users';

    public static function listarUsuariosM($buscar,$filtro)
    {
      
        if (!$buscar)
            return self::orderBy('id', 'desc')->paginate(5);
        else   
            return self::where($filtro, 'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
        

    }


}
