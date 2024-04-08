<?php

use App\Modules\EmployeeKpi\Http\Controllers\EmployeeKpiController;

Route::group(['middleware'=>['web','auth']],function(){

    /**
     * Bills Setup
     */
    Route::group(['prefix' => 'employee-kpi'], function () {
        Route::get('', [EmployeeKpiController::class, 'index'])->name('employee-kpi.index');
        Route::get('/createOrEdit/{id}', [EmployeeKpiController::class, 'createOrEdit'])->name('employee-kpi.createOrEdit');
        Route::post('/createOrUpdate/', [EmployeeKpiController::class, 'storeOrUpdate'])->name('employee-kpi.createOrUpdate');
        Route::get('/destroy/{id}/', [EmployeeKpiController::class, 'destroy'])->name('employee-kpi.destroy');
    });
});