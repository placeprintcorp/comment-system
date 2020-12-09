<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/getComments', 'App\Http\Controllers\CommentsController@getComments');
Route::post('/storeComment', 'App\Http\Controllers\CommentsController@storeComment');
Route::post('/storeReplyComment', 'App\Http\Controllers\CommentsController@storeReplyComment');