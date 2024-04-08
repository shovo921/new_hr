<?php

namespace App\Modules\Payroll\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Payroll\Models\BetaPeak;
use App\Modules\Payroll\Models\Bills\BillsSetup;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmployeeSalaryStop extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'emp_stop_sal';
    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    public function employeeInfo()
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }

}