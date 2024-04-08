<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('leave-type', 'LeaveTypeController');
});