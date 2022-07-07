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

Route::get('phpinfo', function(){
	return phpinfo();
});
	
Auth::routes();
	
Route::get('/', 'HomeController@welc');
Route::get('/home', 'HomeController@welc');

//Rotas Email
Route::get('/emails', 'EmailController@index');

Route::get('/emails/novo', 'EmailController@novo');
Route::post('/emails/novo', 'EmailController@gravar');

Route::get('/emails/editar/{id}', 'EmailController@editar')->where('id','[0-9]+');
Route::post('/emails/editar', 'EmailController@update');

Route::get('/emails/remover/{id}', 'EmailController@remover')->where('id','[0-9]+');


Route::get('/emails/check/{id}', 'EmailController@check')->where('id','[0-9]+');


Route::get('/pedidos', 'PedidosController@index');
Route::get('/pedidos/remover/{id}', 'PedidosController@remover')->where('id','[0-9]+');
Route::get('/pedidos/removeritem/{id}', 'PedidosController@removeritem')->where('id','[0-9]+');

Route::get('/pedidos/editar/{id}', 'PedidosController@editar')->where('id','[0-9]+');
Route::post('/pedidos/editar/', 'PedidosController@update');

Route::get('/pedidos/novo/', 'PedidosController@novo');
Route::post('/pedidos/novo/', 'PedidosController@novomanual');

Route::get('/pedidos/detalhes/{id}', 'PedidosController@detalhes')->where('id','[0-9]+');

Route::get('/pedidos/check', 'PedidosController@check');
Route::get('/pedidos/arquivos', 'PedidosController@arquivos');
Route::get('/pedidos/removerarquivo/{id}', 'PedidosController@removerarquivo')->where('id','[0-9]+');

Route::post('/pedidos/envialogix', 'PedidosController@envialogix');

Route::get('/pedidos/getTrans/{id}', 'PedidosController@getTrans');
Route::get('/pedidos/getClientes/{id}', 'PedidosController@getClientes');
Route::get('/pedidos/getRepres/{id}', 'PedidosController@getRepres');
Route::get('/pedidos/getCond/{id}', 'PedidosController@getCond');
Route::get('/pedidos/integrar/', 'PedidosController@integrar');