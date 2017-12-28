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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'backend'],function (){

    Route::get('/login','Backend\AuthController@showLoginForm');

    Route::post('/login','Backend\AuthController@login');

    Route::get('/logout','Backend\AuthController@logout');

    Route::group(['middleware'=>['auth']],function (){

        Route::get('/',['as' => 'backend.home','uses'=>'Backend\HomeController@index']);

        Route::resource('article', 'Backend\ArticleController');

        Route::resource('category', 'Backend\CategoryController');

        Route::resource('tag', 'Backend\TagController');

        Route::resource('navigation', 'Backend\NavigationController');

        Route::get('upload', ['as' => 'backend.upload.index', 'uses' => 'Backend\UploadController@index']);
    });
});
