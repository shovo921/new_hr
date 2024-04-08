<?php
Route::group(['middleware'=>['web','auth']],function(){
	
	Route::resource('document', 'DocumentController');
});