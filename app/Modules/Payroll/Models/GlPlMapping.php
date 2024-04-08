<?php

namespace App\Modules\Payroll\Models;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class GlPlMapping extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'GLPL_MAPPING';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;

    public function glPlInfoDebit(): HasOne
    {
        return $this->hasOne(GlPlInfoView::class, 'id', 'dac_id');
    }

    public function glPlInfoCredit(): HasOne
    {
        return $this->hasOne(GlPlInfoView::class, 'id', 'cac_id');
    }

}
