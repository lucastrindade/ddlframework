<?php 

use Core\Route\Router;

Router::get('/', '\App\Controllers\HomeController@index');
Router::get('usuarios', '\App\Controllers\HomeController@index');
Router::get('usuarios/{id}', '\App\Controllers\HomeController@index');
Router::get('usuarios/{id}/eventos', '\App\Controllers\HomeController@index');
Router::get('usuarios/{id}/noticias', '\App\Controllers\HomeController@index');