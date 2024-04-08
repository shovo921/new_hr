<?php
Route::group(['middleware'=>['web','auth']],function(){
	
	Route::Resource('salary-head', 'SalaryHeadController');
});