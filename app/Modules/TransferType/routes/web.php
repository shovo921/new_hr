<?php
Route::group(['middleware'=>['web','auth']],function(){
Route::Resource('transfer-type', 'TransferTypeController');
});