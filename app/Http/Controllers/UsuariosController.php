<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class UsuariosController extends Controller
{
    // protected static $buscar;
    // protected static $filtro;

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
}
