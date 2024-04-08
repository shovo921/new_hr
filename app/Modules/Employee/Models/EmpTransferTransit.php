<?php

namespace App\Modules\Employee\Models;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmpTransferTransit extends Model implements AuditableContract
{
    use Auditable;
    protected $table = 'emp_transfer_transit';
    protected $guarded = [];

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    public function employee() {
		return $this->belongsTo(EmployeeVAllInfo::class, 'posting_id', 'posting_id');
	}

    public function crReliever() {
        return $this->belongsTo(EmployeeVAllInfo::class, 'cr_branch_reliever', 'employee_id');
    }

    public function postedOfficer() {
        return $this->belongsTo(EmployeeVAllInfo::class, 'posted_reporting_officer', 'employee_id');
    }

    public function responsible() {
        return $this->belongsTo(EmployeeVAllInfo::class, 'cr_responsible', 'employee_id');
    }



}
