<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Division\Models\Division;
use App\Modules\Payroll\Models\SalaryAccount;
use App\Modules\Designation\Models\Designation;
use App\Modules\District\Models\District;
use App\Modules\Thana\Models\Thana;
use App\Modules\Specialization\Models\Specialization;

class EmployeeDetails extends Model
{
	protected $table = 'employee_details';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

    public $incrementing = false;

    public function par_division() {
		return $this->belongsTo(Division::class, 'par_info_division', 'id');
	}
    public function par_district() {
        return $this->belongsTo(District::class, 'par_info_district', 'id');
    }
    public function par_thana() {
        return $this->belongsTo(Thana::class, 'par_info_thana', 'id');
    }

    public function pre_division() {
		return $this->belongsTo(Division::class, 'pre_info_division', 'id');
	}
    public function pre_district() {
        return $this->belongsTo(District::class, 'pre_info_district', 'id');
    }
    public function pre_thana() {
        return $this->belongsTo(Thana::class, 'pre_info_thana', 'id');
    }
    
    public function designationInfo(){
    	return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    
    public function empBirthPlace(){
        return $this->belongsTo(District::class, 'birth_place', 'id');
    }
    
    public function employmentType(){
        return $this->belongsTo(EmploymentType::class, 'employment_type', 'id');
    }
    public function employeeSalaryAccount(){
        return $this->belongsTo(SalaryAccount::class, 'employee_id', 'employee_id');
    }
}
