<?php

namespace App\Modules\EmployeeIncrement\Models;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Payroll\Models\PayType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SalaryPaySlip extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $table ='SALARYPAY_SLIP';
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
    public function payType(){
        return $this->belongsTo(PayType::class, 'ptype_id', 'ptype_id');
    }
}