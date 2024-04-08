<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('functional-designation', 'FunctionalDesignationController');
});