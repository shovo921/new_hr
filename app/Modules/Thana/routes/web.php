<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('thana', 'ThanaController');
	Route::get('getDistricts', 'ThanaController@getDistricts');
	Route::get('getThanas', 'ThanaController@getThanas');
});