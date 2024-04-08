<?php

namespace App\Modules\Employee\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\BrDepartment\Models\BrDepartment;
use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\DepartmentUnit\Models\DepartmentUnit;
use App\Modules\FunctionalDesignation\Models\FunctionalDesignation;
use App\Modules\JobStatus\Models\JobStatus;
use App\Modules\TransferType\Models\TransferType;
use Illuminate\Database\Eloquent\Model;

class EmployeePosting extends Model
{
    protected $table = 'employee_posting';

    protected $guarded = ["id"];

    public $timestamps = false;

    public function functionalDesignation()
    {
        return $this->belongsTo(FunctionalDesignation::class, 'functional_designation', 'id');
    }

    public function jobStatusInfo()
    {
        return $this->belongsTo(JobStatus::class, 'job_status_id', 'id');
    }

    public function branchInfo()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function transferType()
    {
        return $this->belongsTo(TransferType::class, 'transfer_type_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(BrDivision::class, 'br_division_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(BrDepartment::class, 'br_department_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(DepartmentUnit::class, 'br_unit_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }

//    BR Head Update
    public function headStatus()
    {
        return $this->belongsTo(BrDivHead::class, 'id', 'posting_id');
    }

    public function postdBranch()
    {

        return $this->belongsTo(Branch::class, 'branch_id','id');
    }
    public function branch_name()
    {
        return $this->belongsTo(Branch::class, 'working_at', 'id');
    }
}
