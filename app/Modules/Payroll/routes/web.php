<?php

use App\Modules\Payroll\Http\Controllers\Allowance\AllowanceTypeController;
use App\Modules\Payroll\Http\Controllers\Allowance\EmployeeAllowanceController;
use App\Modules\Payroll\Http\Controllers\Bills\BillsSetupController;
use App\Modules\Payroll\Http\Controllers\Bills\BillsTypeController;
use App\Modules\Payroll\Http\Controllers\Bills\EmployeeBillsController;
use App\Modules\Payroll\Http\Controllers\EmployeeSalaryStopController;
use App\Modules\Payroll\Http\Controllers\GlPlMappingController;
use App\Modules\Payroll\Http\Controllers\SalaryAdjustmentController;
use App\Modules\Payroll\Http\Controllers\SalaryProcessController;

Route::group(['middleware' => ['web', 'auth']], function () {

    /**
     * SalaryAccount Setup
     */
    Route::group(['prefix' => 'salary-account'], function () {
        Route::get('', 'SalaryAccountController@index')->name('sal-acc.index');
        Route::get('/create', 'SalaryAccountController@create');
        Route::post('/create', 'SalaryAccountController@store');
        Route::get('/edit/{id}/', 'SalaryAccountController@edit');
        Route::put('/update/{id}/', 'SalaryAccountController@update');
        Route::get('/edit/{id}/', 'SalaryAccountController@edit');
        Route::get('/authLogin', 'SalaryAccountController@authLogin')->name('sal-acc.authLogin');
        Route::get('/getAccInfo/{accNo}', 'SalaryAccountController@getAccInfo')->name('sal-acc.getAccInfo');
    });

    /**
     * GLPL Account
     */
    Route::group(['prefix' => 'gl-pl'], function () {
        Route::get('', 'GlPlController@index');
        Route::get('/getHead/', 'GlPlController@getHead');
        Route::get('/create', 'GlPlController@create');
        Route::post('/create', 'GlPlController@store');
        Route::get('/edit/{id}/', 'GlPlController@edit');
        Route::put('/update/{id}/', 'GlPlController@update');
    });
    /**
     * PayType
     */
    Route::group(['prefix' => 'pay-type'], function () {
        Route::get('', 'PayTypeController@index');
        Route::get('/create', 'PayTypeController@create');
        Route::post('/create', 'PayTypeController@store');
        Route::get('/edit/{id}/', 'PayTypeController@edit');
        Route::put('/update/{id}/', 'PayTypeController@update');
    });
    /**
     * DeductionType
     */
    Route::group(['prefix' => 'deduction-type'], function () {
        Route::get('', 'DeductionTypeController@index');
        Route::get('/create', 'DeductionTypeController@create');
        Route::post('/create', 'DeductionTypeController@store');
        Route::get('/edit/{id}/', 'DeductionTypeController@edit');
        Route::put('/update/{id}/', 'DeductionTypeController@update');
    });

    /**
     * Salary Setup
     */
    Route::group(['prefix' => 'salary-amount'], function () {
        Route::get('/{employee_id}/', 'SalaryAmountController@index');
        Route::post('', 'SalaryAmountController@store');
        Route::get('/fetch-info/{employee_id}/', 'SalaryAmountController@fetchInfo');
        Route::get('/view/{employee_id}/', 'SalaryAmountController@show');
        Route::get('edit-payhead/{employee_id}/{id}', 'SalaryAmountController@editPhead');
        Route::put('update-payhead/{employee_id}/{id}/', 'SalaryAmountController@updatePhead');
        Route::get('/edit-payment-head/{employee_id}/', 'SalaryAmountController@editPayHead');
        Route::put('/update/{employee_id}/', 'SalaryAmountController@update');
    });

    /**
     * AccountLoan
     */
    Route::group(['prefix' => 'account-loan'], function () {
        Route::get('', 'AccountLoanController@index')->name('loan.index');;
        Route::get('/create', 'AccountLoanController@create');
        Route::post('/create', 'AccountLoanController@store');
        Route::get('/edit/{id}/', 'AccountLoanController@edit');
        Route::put('/update/{id}/', 'AccountLoanController@update');
    });


    /**
     * Allowance Setup
     * Allowance Type Management
     */
    Route::group(['prefix' => 'allowance-type'], function () {
        Route::get('', [AllowanceTypeController::class, 'index']);
        Route::get('/create', [AllowanceTypeController::class, 'create']);
        Route::post('/create', [AllowanceTypeController::class, 'store']);
        Route::get('/edit/{id}', [AllowanceTypeController::class, 'edit']);
        Route::put('/update/{id}/', [AllowanceTypeController::class, 'update']);
    });

    /**
     * Allowance Setup
     */
    Route::group(['prefix' => 'allowance'], function () {
        Route::get('', [EmployeeAllowanceController::class, 'index'])->name('allowance.index');
        Route::get('/createOrEdit/{id}', [EmployeeAllowanceController::class, 'createOrEdit']);
        Route::post('/createOrUpdate', [EmployeeAllowanceController::class, 'storeAndUpdate']);
        Route::get('/authorize/{id}', [EmployeeAllowanceController::class, 'authorizeAllowance']);
        Route::get('/cancel/{id}', [EmployeeAllowanceController::class, 'cancelAllowance']);
        Route::get('/destroy/{id}', [EmployeeAllowanceController::class, 'destroy']);
    });

    /**
     * Salary Process Setup
     */
    Route::group(['prefix' => 'salary-process'], function () {
        Route::get('', [SalaryProcessController::class, 'index']);
        Route::get('/payment', [SalaryProcessController::class, 'glPlMapIndex']);
        Route::get('/final', [SalaryProcessController::class, 'finalSalProcessIndex']);
        Route::get('/dayCount/{empCondition}', [SalaryProcessController::class, 'paidDayProcess']);
        Route::get('/createOrEdit/{id}', [SalaryProcessController::class, 'createOrEdit'])->name('salaryProcess.createOrEdit');
        Route::put('/storeOrUpdate/', [SalaryProcessController::class, 'storeOrUpdate'])->name('salaryProcess.storeOrUpdate');
    });

    Route::group(['prefix' => 'salary-notes'], function () {
        Route::get('', [SalaryProcessController::class, 'salNotes']);
    });

    Route::group(['prefix' => 'gl-pl-mapping'], function () {
        Route::get('', [GlPlMappingController::class, 'index'])->name('glPlMapping.index');
        Route::get('/createOrEdit/{id}', [GlPlMappingController::class, 'createOrEdit']);
        Route::post('/createOrUpdate', [GlPlMappingController::class, 'StoreOrUpdate']);
        Route::get('/destroy/{id}', [GlPlMappingController::class, 'destroy']);
    });


    /**
     * Bills Type
     */
    Route::group(['prefix' => 'bill'], function () {
        Route::get('', [BillsTypeController::class, 'index'])->name('bills-type.index');
        Route::get('/createOrEdit/{id}', [BillsTypeController::class, 'createOrEdit'])->name('bills-type.createOrEdit');
        Route::post('/createOrUpdate/', [BillsTypeController::class, 'storeOrUpdate'])->name('bills-type.createOrUpdate');
        Route::get('/destroy/{id}/', [BillsTypeController::class, 'destroy'])->name('bills-type.destroy');
    });

    /**
     * Bills Setup
     */
    Route::group(['prefix' => 'bill-setup'], function () {
        Route::get('', [BillsSetupController::class, 'index'])->name('bill-setup.index');
        Route::get('/createOrEdit/{id}', [BillsSetupController::class, 'createOrEdit'])->name('bill-setup.createOrEdit');
        Route::post('/createOrUpdate/', [BillsSetupController::class, 'storeOrUpdate'])->name('bill-setup.createOrUpdate');
        Route::get('/destroy/{id}/', [BillsSetupController::class, 'destroy'])->name('bill-setup.destroy');
    });


    /**
     * Bills Setup
     */
    Route::group(['prefix' => 'emp-bills'], function () {
        Route::get('', [EmployeeBillsController::class, 'index'])->name('emp-bills.index');
        Route::get('/createOrEdit/{id}', [EmployeeBillsController::class, 'createOrEdit'])->name('emp-bills.createOrEdit');
        Route::post('/createOrUpdate/', [EmployeeBillsController::class, 'storeOrUpdate'])->name('emp-bills.createOrUpdate');

        Route::get('/tmp', [EmployeeBillsController::class, 'viewTempBill'])->name('emp-bills.tmp');
        Route::get('/editTmpBill/{id}', [EmployeeBillsController::class, 'editTmpBill'])->name('emp-bills.editTmpBill');
        Route::post('/updateTmpBill/', [EmployeeBillsController::class, 'updateTmpBill'])->name('emp-bills.updateTmpBill');

        Route::get('/destroy/{id}/', [EmployeeBillsController::class, 'destroy'])->name('emp-bills.destroy');
    });

    Route::group(['prefix' => 'emp-stop-sal'], function () {
        Route::get('', [EmployeeSalaryStopController::class, 'index'])->name('stop-sal.index');
        Route::get('/createOrEdit/{id}', [EmployeeSalaryStopController::class, 'createOrEdit'])->name('stop-sal.createOrEdit');
        Route::post('/createOrUpdate/', [EmployeeSalaryStopController::class, 'storeOrUpdate'])->name('stop-sal.createOrUpdate');
        Route::get('/destroy/{id}/', [EmployeeSalaryStopController::class, 'destroy'])->name('stop-sal.destroy');
    });

    Route::group(['prefix' => 'emp-salary-adjustment'], function () {
        Route::get('index', [SalaryAdjustmentController::class, 'index'])->name('adjustment.index');
        Route::get('/view/{employee_id}', [SalaryAdjustmentController::class, 'show'])->name('adjustment.show');
        Route::get('edit-pay-or-ded/{employee_id}/{pay_or_ded_type}/{id}', [SalaryAdjustmentController::class, 'editPayDedHead']);
        Route::put('update-pay-or-ded/{employee_id}/{pay_or_ded_type}/{id}/', [SalaryAdjustmentController::class, 'updatePhead']);



    });



});
