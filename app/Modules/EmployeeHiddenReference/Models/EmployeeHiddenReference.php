<?php

namespace App\Modules\EmployeeHiddenReference\Models;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class EmployeeHiddenReference extends Model implements AuditableContract
{
    use SoftDeletes;
    use Auditable;
    
    protected $table = 'employee_hidden_references';

    protected $guarded = ['id'];
    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;
    
    // protected $fillable = ['employee_id', 'ref_name', 'designation', 'mobile_no', 'address', 'organization'];
    
    public $timestamps = false;
}
