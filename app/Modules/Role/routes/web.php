<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('role', 'RoleController')->middleware('auth');
});