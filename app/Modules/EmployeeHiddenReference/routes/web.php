<?php
Route::group(['middleware'=>['web','auth']],function(){
	
	Route::resource('employee-hidden-reference', 'EmployeeHiddenReferenceController');
});
