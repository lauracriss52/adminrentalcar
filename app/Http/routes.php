<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


$app->get('/clientes', 'ClienteController@index');
$app->post('/clientes', 'ClienteController@store');
$app->get('/clientes/{clientes}', 'ClienteController@show');
$app->put('/clientes/{clientes}', 'ClienteController@update');
$app->patch('/clientes/{clientes}', 'ClienteController@update');
$app->delete('/clientes/{clientes}', 'ClienteController@destroy');

$app->get('/servicios', 'ServicioController@index');
$app->post('/servicios', 'ServicioController@store');
$app->get('/servicios/{servicios}', 'ServicioController@show');
$app->put('/servicios/{servicios}', 'ServicioController@update');
$app->patch('/servicios/{servicios}', 'ServicioController@update');
$app->delete('/servicios/{servicios}', 'ServicioController@destroy');


$app->get('/reservas', 'ReservaController@index');
$app->get('/reservas/{reservas}', 'ReservaController@show');


$app->get('/clientes/{clientes}/reservas', 'ClienteReservaController@index');
$app->post('/clientes/{clientes}/reservas', 'ClienteReservaController@store');
$app->put('/clientes/{clientes}/reservas/{reservas}', 'ClienteReservaController@update');
$app->patch('/clientes/{clientes}/reservas/{reservas}', 'ClienteReservaController@update');
$app->delete('/clientes/{clientes}/reservas/{reservas}', 'ClienteReservaController@destroy');


$app->get('/reservas/{reservas}/servicios', 'ReservaServicioController@index');
$app->post('/reservas/{reservas}/servicios/{servicios}', 'ReservaServicioController@store');
$app->delete('/reservas/{reservas}/servicios/{servicios}', 'ReservaServicioController@destroy');


$app->post('/oauth/access_token', function() use($app) {
    return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
});