<?php

use Illuminate\Http\Request;



Route::post('login', 'ApiController@login');
Route::post('refresh', 'AuthController@refresh');
Route::post('register', 'ApiController@register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');

    Route::get('user', 'ApiController@getAuthUser');

    Route::group(['prefix' => 'v1'], function () {
        Route::post('/user', function (Request $request) {
            return "oii";
        });
    });
});
