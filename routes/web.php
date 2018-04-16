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

//Auth::routes();

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('email-verification/error', 'EmailVerificationController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'EmailVerificationController@getVerification')->name('email-verification.check');


Route::get('/home', 'HomeController@index');

/*Toda rota desse grupo vai ter um prefixo admin*/
/*Toda vez que for acessar esse grupo, o kernel vai verificar se o usuário tem
a habilidade de admin (can)*/
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin\\'], //para facilitar mostrar que sempre é na pasta Admin
    function(){
        /*Mostra o que ta no showLoginForm do login de admin*/
        Route::name('login')->get('login', 'Auth\LoginController@showLoginForm');
        //Rota post valida o login
        Route::post('login', 'Auth\LoginController@login');

        //vamos proteger a área administrativa daqui pra baixo
        Route::group(['middleware' => ['isVerified','can:admin']], function(){

            //Rota de logout tb é post
            Route::name('logout')->post('logout', 'Auth\LoginController@logout');
            Route::get('dashboard', function(){
               return view('admin.dashboard');
            });
            Route::name('user_settings.edit')->get('user/settings','Auth\UserSettingsController@edit');
            Route::name('user_settings.update')->put('user/settings','Auth\UserSettingsController@update');
            Route::resource('users', 'UsersController');
            Route::resource('categories', 'CategoriesController');

        });

});

Route::get('/force-login', function(){
   \Auth::loginUsingId(1);
});