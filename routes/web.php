<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Rutas Usuarios
Route::get('/usuarios', 'UsuariosController@listarUsuarios');
Route::post('/usuarios/agregar', 'UsuariosController@agregarUsuario');
Route::post('/usuarios/editar', 'UsuariosController@editarUsuario');
Route::get('/usuarios/comprobarEmail', 'UsuariosController@comprobarEmail');
Route::post('/usuarios/eliminar', 'UsuariosController@eliminarUsuario');

//Rutas productos
Route::get('/productos', 'ProductosController@listarProductos');
Route::get('/productos2', 'ProductosController@listarProductos2');
Route::post('/productos/eliminar', 'ProductosController@eliminarProducto');
Route::get('/productos/comprobarProducto', 'ProductosController@comprobarProducto');
Route::post('/productos/agregar', 'ProductosController@agregarProducto');
Route::post('/productos/editar', 'ProductosController@editarProducto');
Route::get('/productos/selectProductos','ProductosController@selectProductos');

//Rutas ventas
Route::get('/ventas', 'VentasController@listarVentas');
Route::post('/ventas/agregar', 'VentasController@agregarVenta');
Route::post('/ventas/agregarVenta', 'VentasController@agregarVentaCompleta');
Route::post('/ventas/editar', 'VentasController@editarVenta');

//Rutas ventas
Route::get('/detalles', 'DetallesController@listarDetalles');
Route::post('/detalles/agregar', 'DetallesController@agregarDetalle');
Route::post('/detalles/editar', 'DetallesController@editarDetalle');

//Rutas reportes 
Route::get('/reporteMasV', 'ReportesController@reporteMasV');
Route::get('/reporteMenosV', 'ReportesController@reporteMenosV');
Route::get('/reporteMgV', 'ReportesController@reporteMasG');
