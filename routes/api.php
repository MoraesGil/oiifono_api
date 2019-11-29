<?php

Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
Route::post('refresh', 'ApiController@refresh');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::patch('password', 'userController@updatePassword');
    Route::get('me', 'ApiController@me');

    // Person Routes
    Route::resource('/person', 'PersonController', ['except' => ['create', 'edit', 'show']]);
    Route::resource('/patient', 'PatientController', ['except' => ['create', 'edit', 'show']]);

    // Person Assets Routes
    Route::get('cities', 'citycontroller@typeahead');

    //Therapy Routes
    Route::resource('therapy', 'TherapyController');
    Route::get('pathologies', 'PathologyController@typeahead');
    Route::get('strategies', 'StrategyController@typeahead');
    Route::resource('objective', 'ObjectiveController');

    Route::resource('protocol', 'ProtocolController');
});

