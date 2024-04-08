<?php

use App\Modules\EmployeeIncrement\Http\Controllers\EmployeeIncrementController;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('employee-increment', 'EmployeeIncrementController@create');
    Route::post('getEmployeeCurrentSalaryInfo', 'EmployeeIncrementController@getEmployeeCurrentSalaryInfo');
    Route::get('all-sal', 'EmployeeIncrementController@allEmpSal');
    Route::post('employeeSalaryStore', 'EmployeeIncrementController@employeeSalaryStore');

    Route::get('incrementAuthorization', 'EmployeeIncrementController@incrementAuthorization');
    Route::get('incrementAuthorizationView/{employee_id}/{increment_slab}', 'EmployeeIncrementController@authorizedIncrementView');
    /*Route::get('incrementAuthorizationView/', 'EmployeeIncrementController@authorizedIncrementView');*/
    Route::get('authorizedIncrement/{employee_id}/', 'EmployeeIncrementController@authorizedIncrement');
    Route::get('cancelIncrement/{employee_id}/', 'EmployeeIncrementController@cancelIncrement');

    Route::get('salary-certificate', 'EmployeeIncrementController@salaryCertificate');
    Route::get('generateSalaryCertificate', 'EmployeeIncrementController@generateSalaryCertificate');
    Route::get('employeeSalaryCertificate', 'EmployeeIncrementController@employeeSalaryCertificate');

    /**
     * These routes are for Employee Promotion History & Detailed Salary
     */
    Route::get('view-detail-salary/{employee_id}/', 'EmployeeIncrementController@detailEmployeeSalary');
    Route::get('view-promotion-history/{employee_id}/', 'EmployeeIncrementController@allEmployeePromotionHistory');

    Route::get('bulk-increment', [EmployeeIncrementController::class, 'bulkList'])->name('salIncrement.bulkIncrement');
    Route::post('bulk-increment-upload', [EmployeeIncrementController::class, 'import_excel'])->name('salIncrement.import');
    Route::get('incrementDetail/{id}', [EmployeeIncrementController::class, 'incrementedSalaryShow'])->name('salIncrement.detail');
    Route::get('bulkListUpdate', [EmployeeIncrementController::class, 'bulkListUpdate'])->name('salIncrement.bulkListUpdate');
    Route::get('authorizeBulkIncrement', [EmployeeIncrementController::class, 'authorizeBulkIncrement'])->name('salIncrement.bulkAuthorize');

});