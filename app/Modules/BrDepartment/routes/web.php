<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::Resource('br-department', 'BrDepartmentController');
});