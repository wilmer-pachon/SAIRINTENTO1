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

 Route::group(['middleware' =>['guest']], function(){
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');   
});

Route::group(['middleware' =>['auth']], function(){
    
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    // Notificaciones
    Route::post('/notification/get', 'NotificationController@get');
    
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    

    Route::group(['middleware' => ['CommunityManager']], function () {
        // Route::get('/rol', 'RolController@index');
        // Route::get('/rol/selectRol', 'RolController@selectRol');
        
        // Route::get('/user', 'UserController@index');
        // Route::post('/user/registrar', 'UserController@store');
        // Route::put('/user/actualizar', 'UserController@update'); 
        // Route::post('/user/eliminar', 'UserController@eliminar');
    });

    Route::group(['middleware' => ['Administrador']], function () {
        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');

        Route::post('social/{provider}', 'AuthController@social');

        // Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
        // Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

        Route::get('login/facebook', 'Auth\LoginFacebookController@redirect');           
        Route::get('login/facebook/callback', 'Auth\LoginFacebookController@callback');
        
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update'); 
        Route::post('/user/eliminar', 'UserController@eliminar');

        Route::get('/facebook', 'FacebookController@index');
        Route::post('/facebook/registrar', 'FacebookController@store');
        Route::put('/facebook/actualizar', 'FacebookController@update'); 
        Route::post('/facebook/eliminar', 'FacebookController@eliminar');
    });
    
});


// Route::get('/home', 'HomeController@index')->name('home');


