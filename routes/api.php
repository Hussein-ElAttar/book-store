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

Route::group(['middleware' => ['jwt.auth', 'verified']], function () {
    Route::get('books', 'Api\BookController@index');
    Route::post('books', 'Api\BookController@store');
    Route::get('books/{id}', 'Api\BookController@show');
    Route::put('books/{id}', 'Api\BookController@update');
    Route::delete('books/{id}', 'Api\BookController@destroy');
});

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('users/actions/send-email-activation-link', 'Api\UserController@sendActivationLinkEmail');
});

Route::group(['middleware' => ['jwt.auth', 'ValidateEmailVerificationURL']], function () {
    Route::get('users/actions/verify-email', 'Api\UserController@verifyEmail')->name('verifyUserEmail');
});

Route::group(['middleware' => ['jwt.refresh']], function () {
    Route::get('users/actions/refresh-jwt', 'Api\UserController@GetNewAccessToken');
});

Route::post('users/actions/login', 'Api\UserController@login');
Route::post('users/actions/send-reset-password-mail','Api\UserController@SendResetPasswordEmail');
Route::post('users/actions/reset-password','Api\UserController@resetPassword');
Route::post('users/actions/register','Api\UserController@register');
