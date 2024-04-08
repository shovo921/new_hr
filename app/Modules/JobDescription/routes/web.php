<?php
Route::group(['middleware' => ['web', 'auth']], function () {

    /**
     * JD Setup
     */
    Route::group(['prefix' => 'job-description'], function () {
        Route::get('', 'JobDescriptionController@index');
        Route::put('/jd-update/{id}', 'JobDescriptionController@checkAndApproveJd');
        Route::get('/jd/{employee_id}/', 'JobDescriptionController@edit');
        Route::put('/update/{id}/', 'JobDescriptionController@update');
    });

});
