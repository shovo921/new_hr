<?php
Route::group(['middleware'=>['web','auth']],function(){
    Route::resource('site_settings', 'SettingsController');
});
