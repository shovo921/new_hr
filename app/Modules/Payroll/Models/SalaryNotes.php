<?php

namespace App\Modules\Payroll\Models;


use BetaPeak\Auditing\Drivers\FilesystemDriver;
use App\User;
use App\Modules\Payroll\Models\PayType;
use App\Modules\Payroll\Models\DeductionType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SalaryNotes extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'EMP_SALARY_NOTES';
    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    public function payType() {
        return $this->belongsTo(PayType::class, 'type_id', 'ptype_id');
    }
    public function dedType() {
        return $this->belongsTo(DeductionType::class, 'type_id', 'dtype_id');
    }


}