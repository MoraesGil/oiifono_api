<?php

Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
Route::post('refresh', 'ApiController@refresh');

Route::group([], function () {
    Route::get('logout', 'ApiController@logout');
    Route::patch('password', 'UserController@updatePassword');
    Route::patch('/user', 'UserController@update');
    Route::get('me', 'ApiController@me');

    Route::get('cities', 'citycontroller@typeahead');
    Route::get('pathologies', 'PathologyController@typeahead');
    Route::get('strategies', 'StrategyController@typeahead');

    Route::resource('/person', 'PersonController', ['except' => ['create', 'edit', 'show']]);
    Route::resource('/relation', 'RelationController', ['except' => ['create', 'edit']]);
    Route::resource('/address', 'AddressController', ['except' => ['create', 'edit']]);
    Route::resource('/contact', 'ContactController', ['except' => ['create', 'edit']]);
    Route::resource('/patient', 'PatientController', ['except' => ['create', 'edit']]);

    Route::get('/person/{id}/availability', 'AvailabilityController@personsAvailabilities');
    Route::resource('/availability', 'AvailabilityController', ['except' => ['create', 'edit', 'index']]);

    Route::resource('therapy', 'TherapyController', ['except' => ['create', 'edit']]);
    Route::resource('protocol', 'ProtocolController', ['except' => ['create', 'edit']]);
    Route::resource('objective', 'ObjectiveController', ['except' => ['create', 'edit']]);
    Route::resource('appointment', 'AppointmentController', ['except' => ['create', 'edit']]);

    Route::resource('schedule', 'ScheduleController', ['except' => ['create', 'edit']]);
    Route::patch('schedule/{id}/confirm', 'ScheduleController@confirm');
    Route::patch('schedule/{id}/absence', 'ScheduleController@absence');
    Route::get('schedule/best-schedules/{therapyId}', 'ScheduleController@bestSchedules');
    Route::post('schedule/create-schedules/{therapyId}', 'ScheduleController@createSchedules');

    Route::get('appointment/{appointment}/evolution/', 'EvolutionController@index');
});
