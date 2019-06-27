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
        
        $array = array('usuario_id'=> $request->usuario_id, 
                       'fecha' => $fecha2,
                       'total' => $request->total
                    );

        Detalle::agregarDetalleM($array);
    }

    protected static function editarDetalle(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $array = array( 'id'        => $request->id, 
                        'usuario_id'=> $request->usuario_id, 
                        'fecha'     => $request->fecha,
                        'total'     => $request->total
                    );
                        
        Detalle::editarDetalleM($array);
    }
}
