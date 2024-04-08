<?php

Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('education-exam', 'EducationExamController');
});