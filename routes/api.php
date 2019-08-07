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

Route::group(['middleware' => ['jwt.auth', 'verified']], function () {
    Route::get('books', 'Api\BookController@index');
    Route::post('books', 'Api\BookController@store');
    Route::get('books/{id}', 'Api\BookController@show');
    Route::put('books/{id}', 'Api\BookController@update');
    Route::delete('books/{id}', 'Api\BookController@destroy');
});

Route::post('login', 'Api\AuthController@login');

Route::post('users/actions/send-reset-password-mail','Api\Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('users/actions/reset-password','Api\Auth\ResetPasswordController@reset');


Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('email/verify', 'Api\Auth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'Api\Auth\VerificationController@resend')->name('verification.resend');
});