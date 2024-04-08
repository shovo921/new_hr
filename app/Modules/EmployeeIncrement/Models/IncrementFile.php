<?php

namespace App\Modules\EmployeeIncrement\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeeSalary;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncrementFile extends Model
{


    protected $table = 'BULK_INCREMENT_FILE';
    protected $guarded = [''];
    public $incrementing = false;
    public $timestamps = false;


    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;


    public function employeeInfo(): BelongsTo
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }

    public function employeeSalIno(): BelongsTo
    {
        return $this->belongsTo(EmployeeSalary::class, 'employee_id', 'employee_id');
    }
}
