<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'Auth\LoginController@apiLogin');
});
Route::group(['prefix' => 'v1','middleware'=>'api','namespace'=>'Api\v1'], function () {
    Route::get('dropdown-all', 'CommonApiController@allDropDown');
    Route::get('get-map', 'CommonApiController@map');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




//for api service

Route::post('register', 'ApiServiceController@register');
Route::post('login', 'ApiServiceController@login');

Route::group([
    'middleware' => 'auth_service',
    'prefix' => 'v3'
], function ($router) {
//    Route::post('register', 'ApiServiceController@register');
    Route::post('logout', 'ApiServiceController@logout');
    Route::post('refresh', 'ApiServiceController@refresh');
    Route::get('user-profile', 'ApiServiceController@userProfile');
    Route::get('user-info-padmaportal','ApiServiceController@EmpinfoPadma');
    Route::get('brDivInfo','ApiServiceController@branchOrDivInformation');
    Route::get('branchOrDivEmployees','ApiServiceController@branchOrDivEmployees');
    Route::get('designationWiseBranchOrDivEmployees','ApiServiceController@designationWiseBranchOrDivEmployees');
    Route::get('all-user-info-padmaportal','ApiServiceController@allEmpinfoPadma');
    Route::get('pass-encrypt/{id}','ApiServicePasswordController@encrypt');
    Route::get('pass-decrypt/{id}','ApiServicePasswordController@decrypt');
});