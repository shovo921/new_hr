<?php

namespace App\Modules\Payroll\Models\Allowance;

use App\Modules\Payroll\Models\BetaPeak;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AllowanceType extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'employee_allowance_type';
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