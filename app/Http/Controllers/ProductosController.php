<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class productosController extends Controller
{
    protected static function listarProductos (Request $request)
    {
         if (!$request->ajax()) return redirect('/');

        $buscar = $request->_buscar;
     
         
        $obj = Producto::listarProductosM($buscar);
    
        return [
            'pagination' => [
                'total'        => $obj->total(),
                'current_page' => $obj->currentPage(),
                'per_page'     => $obj->perPage(),
                'last_page'    => $obj->lastPage(),
                'from'         => $obj->firstItem(),
                'to'           => $obj->lastItem(),
            ],
            'productos' => $obj
        ]; 
    }

    protected static function agregarProducto(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        
        $array = array('nombre'     => $request->nombre, 
                       'descripcion'=> $request->descripcion,
                       'existencia' => $request->existencia,
                       'precio'     => $request->precio
                    );

        Producto::agregarProductoM($array);
    }

    protected static function editarProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $array = array( 'id'         => $request->id, 
                        'nombre'     => $request->nombre, 
                        'descripcion'=> $request->descripcion,
                        'existencia' => $request->existencia,
                        'precio'    => $request->precio
                    );
                        
        Producto::editarProductoM($array);
    }
    
    protected static function comprobarProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $res = Producto::comprobarProductoM($request->nombre);
        
        if(!$res)
            return response()->json(false);
        else
            return response()->json(true); 
    }

    protected static function eliminarProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;

        Producto::eliminarProductoM($id);
    }
}
