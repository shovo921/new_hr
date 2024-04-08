<?php
Route::group(['middleware'=>['web','auth']],function(){
	
	Route::Resource('industry-type', 'IndustryTypeController');
});