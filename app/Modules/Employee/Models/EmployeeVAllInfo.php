<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Division\Models\Division;
use App\Modules\Payroll\Models\SalaryAccount;
use App\Modules\Designation\Models\Designation;
use App\Modules\District\Models\District;
use App\Modules\Thana\Models\Thana;
use App\Modules\Specialization\Models\Specialization;

class EmployeeVAllInfo extends Model
{
	protected $table = 'V_EMP_ALL_INFO';

}
