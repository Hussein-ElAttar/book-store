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

Route::middleware('jwt.auth')->group(function () {
    Route::get('books', 'Api\BookController@index')->middleware('permission:view books');
    Route::post('books', 'Api\BookController@store')->middleware('permission:store books');
    Route::get('books/{id}', 'Api\BookController@show')->middleware('permission:view books');
    Route::put('books/{id}', 'Api\BookController@update')->middleware('permission:update books');
    Route::delete('books/{id}', 'Api\BookController@destroy')->middleware('permission:destroy books');
});

Route::prefix('users/actions/')->group( function () {
    Route::get('send-email-activation-link', 'Api\UserController@sendActivationLinkEmail')
        ->middleware('jwt.auth');

    Route::get('verify-email', 'Api\UserController@verifyEmail')
        ->name('verifyUserEmail')
        ->middleware('email.verification.url.validate');

    Route::get('refresh-jwt', 'Api\UserController@GetNewAccessToken')
        ->middleware('jwt.refresh');

    Route::post('login', 'Api\UserController@login');
    Route::post('send-reset-password-mail','Api\UserController@SendResetPasswordEmail');
    Route::post('reset-password','Api\UserController@resetPassword');
    Route::post('register','Api\UserController@register');
});

