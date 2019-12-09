<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Entities\Evolution;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('report')->namespace('Reports')->group(function () {
    Route::get('schedule/{doctor_id}', 'ScheduleReportController@index');
    Route::get('appointment/{person_id}', 'PatientAppointmentsReportController@index');
    Route::get('hospitalized', 'HospitalizedReportController@index');
});



// Auth::routes();
