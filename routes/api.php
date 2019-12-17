<?php

Route::post('login', 'ApiController@login')->name('auth.login');
Route::post('register', 'ApiController@register')->name('auth.register');
Route::post('refresh', 'ApiController@refresh')->name('auth.refresh');

Route::group(['middleware' => 'auth.jwt'], function () {
    //settings
    Route::resource('availabilities', 'AvailabilityController', ['only' => ['index', 'store', 'destroy']]);
    Route::get('logout', 'ApiController@logout')->name('auth.logout');
    Route::patch('password', 'UserController@updatePassword')->name('password.update.self');
    Route::patch('user', 'UserController@update')->name('update.self');
    Route::get('me', 'ApiController@me')->name('auth.me');

    //patients
    Route::resource('patients', 'PatientController', ['except' => ['create', 'edit']]);
    Route::get('typeahead/patients', 'PatientController@typeahead')->name('typeahead.patients');
    Route::resource('addresses', 'AddressController', ['except' => ['create', 'edit']]);
    Route::get('typeahead/cities', 'CityController@typeahead')->name('typeahead.cities');
    Route::resource('contacts', 'ContactController', ['only' => ['store','destroy']]);
    Route::resource('relations', 'RelationController', ['only' => ['store','destroy']]);

    // therapy
    Route::get('patients/{id}/active-therapy', 'PatientController@activeTherapy')->name('patients.activeTherapy');
    Route::resource('therapies', 'TherapyController', ['only' => ['store', 'show']]);
    Route::resource('objectives', 'ObjectiveController', ['except' => ['create', 'edit']]);
    Route::get('typeahead/pathologies', 'PathologyController@typeahead')->name('typeahead.pathologies');
    Route::get('typeahead/strategies', 'StrategyController@typeahead')->name('typeahead.strategies');

    //appointments
    Route::resource('appointments', 'AppointmentController', ['except' => ['create', 'edit']]);
    Route::get('appointments/{appointment}/evolutions', 'EvolutionController@index')->name('appointments.evolutions');
    Route::resource('protocols', 'ProtocolController', ['except' => ['create', 'edit']]);

    // schedules
    Route::resource('schedules', 'ScheduleController', ['except' => ['create', 'edit']]);
    Route::patch('schedules/{id}/confirm', 'ScheduleController@confirm')->name('schedule.confirm');
    Route::patch('schedules/{id}/absence', 'ScheduleController@absence')->name('schedule.absence');
    Route::get('schedules/generator/{therapyId}/best-schedules', 'ScheduleController@bestSchedules')->name('schedules.generator.suggestions');
    Route::post('schedules/generator/{therapyId}', 'ScheduleController@generate')->name('schedules.generator.store');
    Route::get('schedules/future-days', 'ScheduleController@futureSchedulesDays')->name('schedules.futuredays');

});
