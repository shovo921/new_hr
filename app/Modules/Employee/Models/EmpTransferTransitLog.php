<?php

namespace App\Modules\Employee\Models;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;


class EmpTransferTransitLog extends Model implements AuditableContract
{
    use Auditable;

    protected $table = 'emp_transfer_transit_log';
    protected $guarded = [];
    public $timestamps = false;
    protected $fillable = ['transit_id', 'posting_id', 'reliever', 'remarks', 'updated_at'];

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    public function employee()
    {
        return $this->belongsTo(EmployeeVAllInfo::class, 'posting_id', 'posting_id');
    }

}
