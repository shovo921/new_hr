<?php

namespace App\Modules\EmployeeKpi\Models;

use App\Modules\Employee\Models\EmployeeVAllInfo;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;

class EmployeeKpi extends Model
{
    protected $table = 'employee_kpi';

    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;


    public function employeeDetails()
    {
        return $this->belongsTo(EmployeeVAllInfo::class, 'employee_id', 'employee_id');
    }

}
