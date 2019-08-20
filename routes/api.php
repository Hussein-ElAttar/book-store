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

    Route::get('activate-user', 'Api\UserController@activateUser')
        ->name('activateUserEmail')
        ->middleware('email.verification.url.validate');

    Route::post('send-reset-password-mail','Api\UserController@SendResetPasswordEmail');
    Route::post('reset-password','Api\UserController@resetPassword');
    Route::post('register','Api\UserController@storeUser');
});


Route::prefix('auth/actions/')->group( function () {
    Route::get('refresh-jwt', 'Api\AuthController@refreshJWT')
        ->middleware('jwt.refresh');

    Route::post('revoke-jwt','Api\AuthController@revokeJWT')
        ->middleware('jwt.revoke');

    Route::post('authenticate', 'Api\AuthController@authenticate');
});
