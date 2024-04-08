<?php

namespace App\Modules\Payroll\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\Payroll\Models\DeductionType;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use App\Modules\Employee\Models\EmployeeDetails;
use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Loan extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'employee_loan';
    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    public function employeeDetails() {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }
    public function branchDetails() {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    public function dedDetails() {
        return $this->belongsTo(DeductionType::class, 'dtype_id', 'dtype_id');
    }

}