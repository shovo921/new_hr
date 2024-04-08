<?php
Route::group(['middleware'=>['web','auth']],function(){
Route::Resource('tour-type', 'TourTypeController');
});