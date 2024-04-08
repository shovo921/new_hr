<?php

Route::resource('attendance', 'AttendanceController');
Route::get('today-attendance', 'AttendanceController@todayAttendance');
Route::get('update-attendance', 'AttendanceController@updateAttendance');


Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);