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

Route::get('/sensors/report/raw/{can_id}/{can_message}', 'SensorsController@reportRaw');

Route::group(['middleware' => ['auth.basic']], function () {
    Route::get('/', 'SensorsController@index');

    // Future work
    //Route::get('/report/{gateway_serial}/param', 'GatewaysController@reportParametrised');

    //Route::resource('gateways', 'GatewaysController');
    //Route::resource('sensor-units', 'SensorUnitsController');
    //Route::resource('sensor-types', 'SensorTypesController');

    Route::get('/sensors/{id}/tare', 'SensorsController@tare');
    Route::post('/sensors/{id}/calibrate', 'SensorsController@calibrate');
    Route::get('/sensors/{id}/data.json', 'SensorsController@data');
    Route::resource('sensors', 'SensorsController');

    Route::resource('measurements', 'MeasurementsController');
    Route::resource('charts', 'ChartsController');
});

