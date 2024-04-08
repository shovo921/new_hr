<?php

namespace App\Modules\Payroll\Models\Bills;

use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Payroll\Models\BetaPeak;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmployeeBills extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'employee_bills';
    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    public function bills(): HasMany
    {
        return $this->hasMany(BillsSetup::class);
    }

    public function billInfo($billSetupId)
    {
        $billInfo = BillsSetup::where('id', $billSetupId)->first();
        return empty($billInfo) ? [] : $billInfo;
    }

    public function employeeInfo()
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }

}