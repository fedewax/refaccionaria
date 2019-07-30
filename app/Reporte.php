<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Reporte extends Model
{
   protected static function reporteMasVM()
   {
      return $results = DB::select('select p.nombre, d.total_vendidos, (d.total_vendidos * p.precio) as total_ganancia
       from
       (
       select id, nombre, precio from productos
       ) as p
       inner join
       (
       select producto_id,  sum(cantidad) as total_vendidos from detalles group by producto_id
       )as d
        on
       p.id = d.producto_id
       group by p.id order by total_vendidos desc');
   }

   protected static function reporteMenosVM()
   {
      return $results = DB::select('select p.nombre, d.total_vendidos, (d.total_vendidos * p.precio) as total_ganancia
       from
       (
       select id, nombre, precio from productos
       ) as p
       inner join
       (
       select producto_id,  sum(cantidad) as total_vendidos from detalles group by producto_id
       )as d
        on
       p.id = d.producto_id
       group by p.id order by total_vendidos asc');
   }

   protected static function reporteMasGM()
   {
      return $results = DB::select('select p.nombre, d.total_vendidos, (d.total_vendidos * p.precio) as total_ganancia
       from
       (
       select id, nombre, precio from productos
       ) as p
       inner join
       (
       select producto_id,  sum(cantidad) as total_vendidos from detalles group by producto_id
       )as d
        on
       p.id = d.producto_id
       group by p.id order by total_ganancia desc');
   }

}
