<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//LENDING


$router->get('/', function () use ($router) {
    return $router->app->version();
});




$router->get('/product', 'ProductController@index');
$router->post('/product/create', 'ProductController@store');
$router->get('/product/{id}', 'ProductController@show');
$router->patch('/product/{id}', 'ProductController@update');
$router->delete('/product/{id}', 'ProductController@destroy');

$router->get('/transaction', 'TransactionController@index');
$router->post('/transaction/create', 'TransactionController@store');
$router->get('/transaction/{id}', 'TransactionController@show');
$router->patch('/transaction/{id}', 'TransactionController@update');
$router->delete('/transaction/{id}', 'TransactionController@destroy');




