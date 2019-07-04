<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detalle;

class DetallesController extends Controller
{
    protected static function listarDetalles (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->_buscar;
     
         
        $obj = Detalle::listarDetallesM($buscar);
    
        return [
            'pagination' => [
                'total'        => $obj->total(),
                'current_page' => $obj->currentPage(),
                'per_page'     => $obj->perPage(),
                'last_page'    => $obj->lastPage(),
                'from'         => $obj->firstItem(),
                'to'           => $obj->lastItem(),
            ],
            'detalles' => $obj
        ]; 
    }

    protected static function agregarDetalle(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        
        $array = array('venta_id'    => $request->venta_id, 
                       'producto_id' => $request->producto_id,
                       'cantidad'    => $request->cantidad
                    );

        Detalle::agregarDetalleM($array);
    }

    protected static function editarDetalle(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $array = array( 'id'          => $request->id, 
                        'venta_id'=> $request->venta_id, 
                        'producto_id' => $request->producto_id,
                        'cantidad'    => $request->cantidad
                    );
               
        Detalle::editarDetalleM($array);
    }
}
