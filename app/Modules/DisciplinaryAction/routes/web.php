<?php
Route::group(['middleware'=>['web','auth']],function(){
    /*Route::resource('disciplinaryAction', 'DisciplinaryActionController');*/
    Route::get('disciplinaryAction', 'DisciplinaryActionController@index');
    Route::get('disciplinaryAction/view/{employee_id}/', 'DisciplinaryActionController@show');
    Route::get('disciplinaryAction/create', 'DisciplinaryActionController@create');
    Route::post('disciplinaryAction/create', 'DisciplinaryActionController@store');
    Route::get('disciplinaryAction/edit/{employee_id}/', 'DisciplinaryActionController@edit');
    Route::put('disciplinaryAction/update/{employee_id}/', 'DisciplinaryActionController@update');
    Route::delete('disciplinaryAction/delete/{employee_id}/', 'DisciplinaryActionController@destroy');

    // DisciplinaryPunishments
    Route::get('disciplinaryAction/getDisciplinaryPunishments/', 'DisciplinaryActionController@disciplinaryPunishments');

    //Disciplinary History

	Route::get('disciplinaryActionHistory/{id}', 'DisciplinaryActionController@disciplinaryActionHistory');

//    Disciplinary Punishment Routes
    Route::get('punishments', 'DisciplinaryPunishmentController@index');

    Route::get('punishments/create', 'DisciplinaryPunishmentController@create');
    Route::post('punishments/create', 'DisciplinaryPunishmentController@store');

    Route::get('punishments/edit/{id}/', 'DisciplinaryPunishmentController@edit');
    Route::put('punishments/update/{id}/', 'DisciplinaryPunishmentController@update');

    Route::delete('punishments/delete/{id}/', 'DisciplinaryPunishmentController@destroy');


});