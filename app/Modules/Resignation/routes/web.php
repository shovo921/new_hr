<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('resign', 'ResignationController');

    Route::get('getEmpBasic', 'ResignationController@getEmployeeBasicInfo');
    Route::get('resign-auth-list', 'ResignationController@authorizeList');
    Route::get('resign-auth/{id}', 'ResignationController@authorizeResign');
    Route::get('resign-cancel/{id}', 'ResignationController@cancelResign');
});