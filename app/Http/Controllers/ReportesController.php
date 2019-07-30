<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reporte;

class ReportesController extends Controller
{
    protected static function reporteMasV()
    {
        $r =  Reporte::reporteMasVM();
        return $r;
    }

    protected static function reporteMenosV()
    {
        $r =  Reporte::reporteMenosVM();
        return $r;
    }

    protected static function reporteMasG()
    {
        $r =  Reporte::reporteMasGM();
        return $r;
    }
}
