<?php

namespace App\Modules\JobDescription\Models;


use BetaPeak\Auditing\Drivers\FilesystemDriver;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\FunctionalDesignation\Models\FunctionalDesignation;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;


class EmployeeJD extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'employee_jd';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;


    public function user() {
        return $this->belongsTo(User::class, 'approver_id', 'employee_id');
    }
    public function employeeDetails() {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }
    public function functionalDesignation()
    {
        return $this->belongsTo(FunctionalDesignation::class, 'func_designation_id', 'id');
    }
}
