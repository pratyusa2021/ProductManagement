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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('/','ProductController');
Route::get('/{id}/view','ProductController@show');
Route::post('/update','ProductController@update');
Route::get('/{id}/delete','ProductController@destroy');
Route::get('/{id}/delete-image','ProductController@destroyImage');
