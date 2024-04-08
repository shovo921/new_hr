<?php

namespace App\Modules\Designation\Models;

use App\Modules\Payroll\Models\Bills\BillsSetup;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Employee\Models\EmploymentType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Designation extends Model implements AuditableContract
//class Designation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'designation';

    protected $guarded = ['id'];

    public $timestamps = false;

    /*protected $auditInclude = [
        'employment_type',
        'designation',
    ];*/

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class, 'employment_type', 'id');
    }

    public function billSetup(): HasMany
    {
        return $this->hasMany(BillsSetup::class);

    }
}
