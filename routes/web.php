<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {return view('login');})->middleware('guest');


Route::get('clear-all', function () {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('clear-compiled');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    dd('Cached Cleared');
});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/settings', 'SettingsController@index')->name('settings.index');
    Route::post('/settings', 'SettingsController@store')->name('settings.store');


    /**********************************************/

    Route::get('getBranchDivisions', 'CommonController@getBranchDivisions');
    Route::get('getBranchEmployees', 'CommonController@getBranchEmployees');
    Route::get('getBranchDivisionDepartments', 'CommonController@getBranchDivisionDepartments');
    Route::get('getBranchDivisionDepartmentUnits', 'CommonController@getBranchDivisionDepartmentUnits');
    Route::get('getEmployeeAttendaceInfo', 'CommonController@getEmployeeAttendaceInfo');

    Route::get('common', 'CommonController@common');
});
