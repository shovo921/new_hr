<?php

use App\Modules\User\Http\Controllers\SystemUserController;

Route::group(['middleware' => 'auth'], function () {
    //Route::resource('system-users', 'SystemUserController');
    Route::resource('profile', 'SystemUserController');
    Route::post('change-password','SystemUserController@changePassword')->name('change-password');
});

/*Route::post('profile','SystemUserController@profile')->name('profile');*/
Route::get('forget-password','ForgetPasswordController@form')->name('forget-password');
Route::post('forget-password','ForgetPasswordController@forgetPassword')->name('forget-password.save');
Route::get('forget-password-otp','ForgetPasswordController@formOtp')->name('forget-password.otp-view');
Route::post('forget-password-otp-verify','ForgetPasswordController@otpVerify')->name('forget-password.otp-verify');
Route::get('/empId/{employee_id}', 'SystemUserController@empIdLogin');

//for user password reset from admin
Route::get('PasswordReset', [SystemUserController::class, 'pass_reset_index']);
Route::post('PasswordReset', [SystemUserController::class, 'pass_reset_store'])->name('reset.password');
