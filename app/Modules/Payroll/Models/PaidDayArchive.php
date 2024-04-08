<?php

namespace App\Modules\Payroll\Models;


use BetaPeak\Auditing\Drivers\FilesystemDriver;
use App\Modules\Employee\Models\EmployeeDetails;
use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class PaidDayArchive extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'EMP_PAID_DAY_COUNT_ARCHIVE';
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
}