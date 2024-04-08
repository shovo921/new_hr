<?php

/**
 *	Employee Helpers
 */
function getEmploymentType($employment_type_id='')
{
	$employmentType = DB::table('employment_types')->where('id', $employment_type_id);
	if($employmentType->count() > 0) {
		$employment_type = $employmentType->first();

		return $employment_type->employment_type;
	} else {
		return '';
	}
}