<?php

namespace App\Modules\DisciplinaryCategory\Models;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class DisciplinaryCategory extends Model implements AuditableContract
{
    use Auditable;
    use softDeletes;
    protected $table = 'disciplinary_categories';
    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    protected $guarded = ["id"];
    
    public $timestamps = false;
}
