<?php

namespace App\Modules\Payroll\Models;

use App\Modules\Employee\Models\EmployeeSalary;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use App\Modules\Employee\Models\EmployeeDetails;
use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;



class SalaryAccount extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'employee_salary_account';
    protected $guarded = ['id'];
    protected $fillable=['employee_id','branch_id','account_no','customer_id','created_at','updated_at','created_by','updated_by','status'];
    public $timestamps = false;
    //public $incrementing = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;


    public function employee() {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }
    public function employeeDetails() {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }
    public function salaryAccount() {
        return $this->belongsTo(EmployeeSalary::class, 'employee_id', 'employee_id');
    }
}
