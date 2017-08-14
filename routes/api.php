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
Route::post('/register','RegisterController@register');

Route::get('/topics','TopicsController@index');
Route::get('/topics/{topic}','TopicsController@show');
Route::middleware('auth:api')->patch('/topics/{topic}','TopicsController@update');
Route::middleware('auth:api')->post('/topics','TopicsController@store');
Route::middleware('auth:api')->delete('/topics/{topic}','TopicsController@destroy');
Route::middleware('auth:api')->post('/topics/{topic}/posts','PostsController@store');
Route::middleware('auth:api')->patch('posts/{post}','PostsController@update');
Route::middleware('auth:api')->delete('posts/{post}','PostsController@destroy');
Route::get('/topic/{topic}/posts','PostsController@index');
Route::get('topic/{topic}/posts/{post}','PostsController@show');
