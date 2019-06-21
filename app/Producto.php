<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $timestamps = false;

    protected static function listarProductosM($buscar)
    {
        if (!$buscar)
            return self::orderBy('id', 'desc')->paginate(5);
        else   
            return self::where('nombre', 'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
    }

    protected static function eliminarProductoM($id)
    {
        Producto::destroy($id);
    }

    protected static function agregarUsuarioM($array)
    {
        $obj = new Producto();
        $obj->nombre = $array["nombre"];
        $obj->descripcion = $array["descripcion"];
        $obj->existencia = $array["existencia"];
        $obj->precio = $array["precio"];
        $obj->save();
    }
    
    protected static function editarProductoM($array)
    {
        $obj = Producto::find($array["id"]);
        $obj->nombre = $array["nombre"];
        $obj->descripcion = $array["descripcion"];
        $obj->existencia = $array["existencia"];
        $obj->precio = $array["precio"];
        $obj->save();
    }

    protected static function comprobarProductoM($nombre)
    {
        return self::select('nombre')->where('nombre', $nombre)->first();
    }

    
}
