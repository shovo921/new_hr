<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('reporting-heads', 'ReportingManagersController')->middleware('auth');
});