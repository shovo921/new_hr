<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::Resource('department-unit', 'DepartmentUnitController');
});