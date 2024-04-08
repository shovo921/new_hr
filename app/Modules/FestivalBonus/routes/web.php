<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('FestivalBonus', 'FestivalBonusController');
});

Route::group(['middleware' => ['web', 'auth']], function () {
//    Route::get('FestivalBonus/process', 'FestivalBonusProcess@HolidayProcess')->name('holidays.process');
    Route::get('FestivalBonus/csv/index', 'FestivalBonusProcessController@CsvIndex')->name('bonus.csv.index');
    Route::post('FestivalBonus/csv/import', 'FestivalBonusProcessController@CsvIport')->name('bonus.csv.import');
    Route::get('FestivalBonus/csv/download', 'FestivalBonusProcessController@DownloadDemoCSv')->name('bonus.csv.download');
});
