<?php
Route::group(['middleware'=>['web','auth']],function(){
	
	Route::resource('leave', 'LeaveController');

	Route::get('getLeaveTotalDays', 'LeaveController@getLeaveTotalDays');

	Route::get('allApplication', 'LeaveController@allApplication');
	Route::get('waiting-list', 'LeaveController@waitingList');

    Route::get('waiting-list-hr', 'LeaveController@waitingListHR');

    Route::get('leave-form/{id}', 'LeaveController@leaveForm');

	Route::get('approveLeave/{id}', 'LeaveController@approveLeave');
	Route::get('cancelLeave/{id}', 'LeaveController@cancelLeave');

	Route::get('leave-approve/{id}', 'LeaveController@leaveRelieverApprove');
	Route::put('leave-approve-update/{id}', 'LeaveController@leaveRelieverApproveUpdate');

    Route::get('leave-approve-hr/{id}', 'LeaveController@leaveHrApprove');
	Route::put('leave-update/{id}', 'LeaveController@leaveHrApproveUpdate');

	Route::get('edit-employee-leave/{id}', 'LeaveController@editEmployeeLeave');
	Route::put('update-employee-leave/{id}', 'LeaveController@updateEmployeeLeave');
	
	Route::get('view-employee-leave/{employee_id}', 'LeaveController@viewEmployeeLeave');
	
	Route::get('checkEmployeeLeaveConditions', 'LeaveController@checkEmployeeLeaveConditions');
	Route::get('checkLeaveBalance', 'LeaveController@checkLeaveBalance');

//    Leave LOG
    Route::get('leave-application-log/{id}', 'LeaveController@viewLeaveLogInformation');
});