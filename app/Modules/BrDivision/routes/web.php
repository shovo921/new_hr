<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::Resource('br-division', 'BrDivisionController');
});