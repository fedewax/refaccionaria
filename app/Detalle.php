<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    public $timestamps = false;

    protected $filelable = [
        'venta_id','producto_id','cantidad',
        'ventas.id as ventas_id', 
        'productos.id','productos.nombre as nombre_producto',
        'ventas.id','ventas.venta_id','ventas.usuario_id','ventas.cantidad'
    ];

    protected static function listarDetallesM($buscar)
    {
        if (!$buscar)
            return self::join('ventas','detalles.venta_id','=','ventas.id')
                         ->join('productos','detalles.producto_id','=','productos.id')
                         ->select('detalles.id','ventas.id as venta_id','productos.id as producto_id','productos.nombre as nombre_producto','detalles.cantidad')
                         ->orderBy('detalles.id', 'desc')->paginate(5);
        else   
            return self::join('ventas','detalles.venta_id','=','ventas.id')
                        ->join('productos','detalles.producto_id','=','productos.id')
                        ->select('detalles.id','ventas.id as venta_id','productos.id as producto_id','productos.nombre as nombre_producto','detalles.cantidad')
                        ->where('productos.nombre', 'like','%'.$buscar.'%')->orderBy('detalles.id','desc')
                        ->paginate(5);
    }

    protected static function agregarDetalleM($array)
    {
        $obj = new Detalle();
        $obj->venta_id = $array["venta_id"];
        $obj->producto_id = $array["producto_id"];
        $obj->cantidad = $array["cantidad"];
        $obj->save();
    }
    
    protected static function editarDetalleM($array)
    {
        $obj = Detalle::find($array["id"]);
        $obj->venta_id = $array["venta_id"];
        $obj->producto_id = $array["producto_id"];
        $obj->cantidad = $array["cantidad"];
        $obj->save();
    }
}
