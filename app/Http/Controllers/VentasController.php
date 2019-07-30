<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;
use App\Detalle;
use Carbon\Carbon;

class VentasController extends Controller
{
    protected static function listarVentas (Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->_buscar;
             
        $obj = Venta::listarVentasM($buscar);
    
        return [
            'pagination' => [
                'total'        => $obj->total(),
                'current_page' => $obj->currentPage(),
                'per_page'     => $obj->perPage(),
                'last_page'    => $obj->lastPage(),
                'from'         => $obj->firstItem(),
                'to'           => $obj->lastItem(),
            ],
            'ventas' => $obj
        ]; 
    }

    protected static function agregarVenta(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        
        $fecha = Carbon::parse($request->fecha);
        
        $fecha2 = $fecha->format('Y-m-d',$fecha);


        $array = array('usuario_id'=> $request->usuario_id, 
                       'fecha' => $fecha2,
                       'total' => $request->total
                      );

        Venta::agregarVentaM($array);
    }

    protected static function editarVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $fecha = Carbon::parse($request->fecha);
        
        $fecha2 = $fecha->format('Y-m-d',$fecha);
        
        $array = array( 'id'        => $request->id, 
                        'usuario_id'=> $request->usuario_id, 
                        'fecha'     => $request->fecha2,
                        'total'     => $request->total
                      );
                        
        Venta::editarVentaM($array);
    }

    protected static function agregarVentaCompleta(Request $request)
    {
        $fecha = Carbon::now();

        $usuario_id = auth()->id();

        $fecha = Carbon::parse($request->fecha);
        
        $fecha2 = $fecha->format('Y-m-d',$fecha);

        $array = array('usuario_id' => $usuario_id,
                       'fecha' => $fecha2,
                       'total' => $request->total
                       );

        $venta_id = Venta::agregarVentaM($array);

        $array2 = $request->arrayDetalles;

        Detalle::agregarDetallesM($array2,$venta_id);
    }
}
