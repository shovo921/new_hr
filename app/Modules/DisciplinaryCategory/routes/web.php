<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('disciplinary-category', 'DisciplinaryCategoryController');
});