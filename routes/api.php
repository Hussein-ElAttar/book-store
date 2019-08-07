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
    Route::get('refresh', 'Api\AuthController@refresh');
});

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('books', 'Api\BookController@index');
    Route::post('books', 'Api\BookController@store');
    Route::get('books/{id}', 'Api\BookController@show');
    Route::put('books/{id}', 'Api\BookController@update');
    Route::delete('books/{id}', 'Api\BookController@destroy');
});

Route::post('login', 'Api\AuthController@login');
Route::post('password/email','Api\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset','Api\Auth\ResetPasswordController@reset')->name('password.reset');