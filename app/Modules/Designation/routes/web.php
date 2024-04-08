<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('designation', 'DesignationController');
	//Route::get('getDistricts', 'ThanaController@getDistricts');
});