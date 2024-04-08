<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::Resource('specialization', 'SpecializationController');
});