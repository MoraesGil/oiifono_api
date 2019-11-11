<?php

use Illuminate\Http\Request;



Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
Route::post('refresh', 'ApiController@refresh');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('me', 'ApiController@me');
});

Route::get('cities/tp/{name}', 'citycontroller@typeahead');


Route::resource('/person', 'PersonController', ['except' => ['create', 'edit', 'show']]);
