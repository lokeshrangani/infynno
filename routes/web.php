<?php

use Illuminate\Support\Facades\Route;


Route::get('/','UserController@index');
Route::post('/register','UserController@store');
Route::post('/login','UserController@login');
Route::get('/logout','UserController@logout');

Route::prefix('blog')->group(function () {
    Route::get('/','BlogController@index');
    Route::post('/add','BlogController@store');
    Route::get('/all','BlogController@list');
    Route::get('/details/{id}','BlogController@show');
    Route::get('/delete/{id}','BlogController@destroy');
});