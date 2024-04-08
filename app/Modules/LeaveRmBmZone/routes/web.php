<?php

use App\Modules\LeaveRmBmZone\Http\Controllers\BrBomController;
use App\Modules\LeaveRmBmZone\Http\Controllers\RMController;
use App\Modules\LeaveRmBmZone\Http\Controllers\ZoneController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['web','auth']],function(){

    Route::group(['prefix' => 'zone'], function () {
            Route::get('', [ZoneController::class, 'index'])->name('zone.index');
            Route::get('/createOrEdit/{id}', [ZoneController::class, 'createOrEdit'])->name('zone.createOrEdit');
            Route::post('/createOrUpdate/', [ZoneController::class, 'storeOrUpdate'])->name('zone.createOrUpdate');
            Route::get('/destroy/{id}/', [ZoneController::class, 'destroy'])->name('zone.destroy');
    });

    Route::group(['prefix' => 'BrBom'], function () {
        Route::get('', [BrBomController::class, 'index'])->name('BrBom.index');
        Route::get('/createOrEdit/{id}', [BrBomController::class, 'createOrEdit'])->name('BrBom.createOrEdit');
        Route::post('/createOrUpdate/', [BrBomController::class, 'storeOrUpdate'])->name('BrBom.createOrUpdate');
        Route::get('/destroy/{id}/', [BrBomController::class, 'destroy'])->name('BrBom.destroy');
    });

    Route::group(['prefix' => 'Rm'], function () {
        Route::get('', [RMController::class, 'index'])->name('Rm.index');
        Route::get('/createOrEdit/{id}', [RMController::class, 'createOrEdit'])->name('Rm.createOrEdit');
        Route::post('/createOrUpdate/', [RMController::class, 'storeOrUpdate'])->name('Rm.createOrUpdate');
        Route::get('/destroy/{id}/', [RMController::class, 'destroy'])->name('Rm.destroy');
    });

});