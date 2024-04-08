<?php
Route::group(['middleware'=>['web','auth']],function(){
	
	Route::Resource('job-status', 'JobStatusController');
});