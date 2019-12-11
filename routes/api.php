<?php

Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
Route::post('refresh', 'ApiController@refresh');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::patch('password', 'UserController@updatePassword');
    Route::patch('/user', 'UserController@update');
    Route::get('me', 'ApiController@me');

    Route::get('cities', 'citycontroller@typeahead');
    Route::get('pathologies', 'PathologyController@typeahead');
    Route::get('strategies', 'StrategyController@typeahead');

    Route::resource('/patients', 'PatientController', ['except' => ['create', 'edit']]);
    Route::resource('/relations', 'RelationController', ['except' => ['create', 'edit']]);
    Route::resource('/addresses', 'AddressController', ['except' => ['create', 'edit']]);
    Route::resource('/contacts', 'ContactController', ['except' => ['create', 'edit']]);
    Route::resource('/availabilities', 'AvailabilityController', ['only' => ['index', 'store', 'destroy']]);

    Route::resource('therapies', 'TherapyController', ['except' => ['create', 'edit']]);
    Route::resource('protocols', 'ProtocolController', ['except' => ['create', 'edit']]);
    Route::resource('objectives', 'ObjectiveController', ['except' => ['create', 'edit']]);
    Route::resource('appointments', 'AppointmentController', ['except' => ['create', 'edit']]);

    Route::resource('schedules', 'ScheduleController', ['except' => ['create', 'edit']]);
    Route::patch('schedules/{id}/confirm', 'ScheduleController@confirm');
    Route::patch('schedules/{id}/absence', 'ScheduleController@absence');
    Route::get('schedules/generator/{therapyId}/best-schedules', 'ScheduleController@bestSchedules');
    Route::post('schedules/generator/{therapyId}', 'ScheduleController@generate');

    Route::get('appointment/{appointment}/evolution/', 'EvolutionController@index');
});
