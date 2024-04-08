<?php

Route::group(['middleware'=>['web','auth']],function(){
	Route::resource('professional-institue', 'ProfessionalInstitueController');
});