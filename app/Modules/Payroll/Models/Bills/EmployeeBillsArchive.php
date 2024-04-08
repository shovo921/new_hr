<?php

namespace App\Modules\Payroll\Models\Bills;

use App\Modules\Payroll\Models\BetaPeak;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmployeeBillsArchive extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'EMP_BILLS_ARCHIVE';
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