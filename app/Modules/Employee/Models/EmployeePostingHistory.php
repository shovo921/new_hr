<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Modules\JobStatus\Models\JobStatus;
use App\Modules\Designation\Models\Designation;
use App\Modules\FunctionalDesignation\Models\FunctionalDesignation;
use App\Modules\TransferType\Models\TransferType;
use App\Modules\Branch\Models\Branch;
use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\BrDepartment\Models\BrDepartment;
use App\Modules\DepartmentUnit\Models\DepartmentUnit;

class EmployeePostingHistory extends Model
{
    protected $table = 'employee_posting_history';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

    public function employee() {
		return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
	}
    public function designation() {
		return $this->belongsTo(Designation::class, 'designation_id', 'id');
	}
	public function functionalDesignation() {
		return $this->belongsTo(FunctionalDesignation::class, 'functional_designation', 'id');
	}
	public function transferType() {
		return $this->belongsTo(TransferType::class, 'transfer_type_id', 'id');
	}
	public function branch() {
		return $this->belongsTo(Branch::class, 'branch_id', 'id');
	}
	public function division() {
		return $this->belongsTo(BrDivision::class, 'br_division_id', 'id');
	}
	public function department() {
		return $this->belongsTo(BrDepartment::class, 'br_department_id', 'id');
	}
	public function unit() {
		return $this->belongsTo(DepartmentUnit::class, 'br_unit_id', 'id');
	}
	public function jobStatus() {
		return $this->belongsTo(JobStatus::class, 'job_status_id', 'id');
	}
}
