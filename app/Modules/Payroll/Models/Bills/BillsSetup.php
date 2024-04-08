<?php

namespace App\Modules\Payroll\Models\Bills;

use App\Modules\Designation\Models\Designation;
use App\Modules\Payroll\Models\BetaPeak;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class BillsSetup extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'bills_setup';
    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    public function billsType(): HasMany
    {
        return $this->hasMany(BillsType::class,'id','bill_type_id');
    }

    public function designation(): HasMany
    {
        return $this->hasMany(Designation::class,'id','designation_id');
    }

}