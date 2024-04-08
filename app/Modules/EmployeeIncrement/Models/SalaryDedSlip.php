<?php

namespace App\Modules\EmployeeIncrement\Models;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Payroll\Models\DeductionType;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SalaryDedSlip extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $table ='SALARYDED_SLIP';
    protected $guarded = [''];
    public $incrementing = false;
    public $timestamps = false;


    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;


    public function employee(){
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }
    public function dedType(){
        return $this->belongsTo(DeductionType::class, 'dtype_id', 'dtype_id');
    }
}