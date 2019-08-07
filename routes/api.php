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


Route::group(['middleware' => ['jwt.refresh']], function () {
    Route::get('refresh', 'AuthController@refresh');
});

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('books', 'BookController@index');
    Route::post('books', 'BookController@store');
    Route::get('books/{id}', 'BookController@show');
    Route::put('books/{id}', 'BookController@update');
    Route::delete('books/{id}', 'BookController@destroy');
});

Route::post('login', 'AuthController@login');
Route::post('password/email','Api\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset','Api\Auth\ResetPasswordController@reset')->name('password.reset');