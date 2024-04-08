<?php

Route::get('all-employee', 'ReportController@allEmployee');
Route::get('employee-on-leave', 'ReportController@employeeOnLeave');
Route::get('branch-leave', 'ReportController@branchLeave');
Route::get('without-pay-report', 'ReportController@withoutPay');
Route::get('employee-leave-balance', 'ReportController@withoutPay');
