<?php

namespace App\Modules\Payroll\Models;


use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmployeePayOrDedTemp extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'EMP_SAL_PAY_DED_TEMP';
    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;



}