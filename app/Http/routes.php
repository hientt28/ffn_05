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

Route::auth();

Route::group(['middleware' => 'web'], function () {
    Route::get('/', [
        'as' => '/',
        'uses' => 'HomeController@index',
    ]);

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::resource('teams', 'Admin\TeamController');
        Route::resource('players', 'Admin\PlayerController');
        Route::resource('profile', 'Admin\UserController', [
            'only' => [
                'index',
                'edit',
                'update'
            ]
        ]);
    });

    Route::group(['prefix' => 'users', 'namespace' => 'User'], function () {
        Route::resource('profile', 'UserController', [
            'only' => [
                'index',
                'edit',
                'update'
            ]
        ]);
    });

    Route::get('register/verify/{confirmation_code}', [
        'as' => 'user.active',
        'uses' => 'Auth\AuthController@confirm'
    ]);

});
