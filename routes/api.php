<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//é um endpoint, algo que vai ser acessível por alguém que vai consumir
/*Route::get('/test', function(){
    return \CodeFlix\Models\User::all();
});*/

\ApiRoute::version('v1', function (){
    ApiRoute::group([
        'namespace' => 'CodeFlix\Http\Controllers\Api',
        'as' => 'api'
    ], function (){
       ApiRoute::post('/access_token', [
           'uses' => 'AuthController@accessToken',
           'middleware' => 'api.throttle',
           'limit' => 10,
           'expires' => 1
       ])->name('.access_token');
        ApiRoute::post('/refresh_token', [
            'uses' => 'AuthController@refreshToken',
            'middleware' => 'api.throttle',
            'limit' => 10,
            'expires' => 1
        ])->name('.refresh_token');

        //grupo que vai precisar do usuário autenticado
        ApiRoute::group([
            'middleware' => ['api.throttle','api.auth'],
            'limit' => 100, //por rotas (cada rota tem esse limite)
            'expires' => 3
        ], function(){
            //rotas: endpoints que precisarão de autenticação
            ApiRoute::post('/logout', 'AuthController@logout');
            ApiRoute::get('/test', function(){
                return "Opa! Estou autenticado";
            });
        });
    });
});



