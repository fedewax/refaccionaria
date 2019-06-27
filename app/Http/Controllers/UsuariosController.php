<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class UsuariosController extends Controller
{
    protected static function listarUsuarios(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->_buscar;
        $filtro = $request->_filtro;
         
        $obj = Usuario::listarUsuariosM($buscar,$filtro);

        return [
            'pagination' => [
                'total'        => $obj->total(),
                'current_page' => $obj->currentPage(),
                'per_page'     => $obj->perPage(),
                'last_page'    => $obj->lastPage(),
                'from'         => $obj->firstItem(),
                'to'           => $obj->lastItem(),
            ],
            'usuarios' => $obj
        ]; 
    }

    protected static function agregarUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $clave = bcrypt($request->clave1);
        
        $array = array('nombre' => $request->nombre, 
                        'email' => $request->email,
                        'clave' => $clave,
                        'rol'   => $request->rol);
                        
        Usuario::agregarUsuarioM($array);
    }

    protected static function editarUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $array = array( 'id' => $request->id, 
                        'nombre' => $request->nombre, 
                        'email' => $request->email,
                        'rol'   => $request->rol);
                        
        Usuario::editarUsuarioM($array);
    }
    
    protected static function comprobarEmail(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $res = Usuario::comprobarEmailM($request->email);
        
        if(!$res)
            return response()->json(false);
        else
            return response()->json(true); 
    }

    protected static function eliminarUsuario(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $id = $request->id; 
           
        Usuario::eliminarUsuarioM($id);
    }

    
}
