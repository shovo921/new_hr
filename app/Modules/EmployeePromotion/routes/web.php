<?php
Route::group(['middleware'=>['web','auth']],function(){
	Route::get('employee-promotion', 'EmployeePromotionController@create');
	
	Route::post('getEmployeePromotedSalaryInfo', 'EmployeePromotionController@getEmployeePromotedSalaryInfo');
	Route::post('employeePromotionStore', 'EmployeePromotionController@employeePromotionStore');

	Route::get('promotionAuthorization', 'EmployeePromotionController@promotionAuthorization');
	Route::get('authorizedPromotion/{employee_id}/', 'EmployeePromotionController@authorizedPromotion');
	Route::get('authorizedPromotionView/{employee_id}/', 'EmployeePromotionController@authorizedPromotionView');
	Route::get('cancelPromotion/{employee_id}/', 'EmployeePromotionController@cancelPromotion');
});