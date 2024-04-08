<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('holiday', 'HolidayController');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('holidays/process', 'HolidayProcessController@HolidayProcess')->name('holidays.process');
    Route::get('holidays/csv/index', 'HolidayProcessController@CsvIndex')->name('csv.index');
    Route::post('holidays/csv/import', 'HolidayProcessController@CsvIport')->name('csv.import');
    Route::get('holidays/csv/download', 'HolidayProcessController@DownloadDemoCSv')->name('csv.download');
});
