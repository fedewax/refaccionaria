<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public $timestamps = false;

    protected $filelable = [
        'usuario_id','fecha','total',
        'users.id','users.email as usuario', 
        'ventas.id','ventas.usuario_id','ventas.fecha','ventas.total'
    ];

    protected static function listarVentasM($buscar)
    {
        if (!$buscar)
            return self::join('users','ventas.usuario_id','=','users.id')
                         ->select('ventas.id','users.id as usuario_id','users.email as email','ventas.fecha','ventas.total')
                         ->orderBy('ventas.id', 'desc')->paginate(5);
        else   
            return self::join('users','ventas.usuario_id','=','users.id')
                        ->select('users.email as email','ventas.fecha','ventas.total')
                        ->where('users.email', 'like','%'.$buscar.'%')->orderBy('users.id','desc')
                        ->paginate(5);
    }

    protected static function agregarVentaM($array)
    {
        $obj = new Venta();
        $obj->usuario_id = $array["usuario_id"];
        $obj->fecha = $array["fecha"];
        $obj->total = $array["total"];
        $obj->save();
        $venta_id = $obj->id;
        return $venta_id;
    }
    
    protected static function editarVentaM($array)
    {
        $obj = Venta::find($array["id"]);
        $obj->usuario_id = $array["usuario_id"];
        $obj->fecha = $array["fecha"];
        $obj->total = $array["total"];
        $obj->save();
    }
}
