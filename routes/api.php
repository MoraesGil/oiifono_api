<?php

Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
Route::post('refresh', 'ApiController@refresh');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::patch('password', 'userController@updatePassword');
    Route::get('me', 'ApiController@me');

    Route::get('cities', 'citycontroller@typeahead');
    Route::get('pathologies', 'PathologyController@typeahead');
    Route::get('strategies', 'StrategyController@typeahead');

    Route::resource('/person', 'PersonController', ['except' => ['create', 'edit', 'show']]);
});

Route::resource('/patient', 'PatientController', ['except' => ['create', 'edit', 'show']]);


