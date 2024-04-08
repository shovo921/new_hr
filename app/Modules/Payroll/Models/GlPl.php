<?php

namespace App\Modules\Payroll\Models;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class GlPl extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'salary_gl_pl';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;


    public function payType()
    {
        return $this->belongsTo(PayType::class, 'head_id', 'ptype_id');
    }

    public function deductionType()
    {
        return $this->belongsTo(DeductionType::class, 'head_id', 'dtype_id');
    }

    public function hasOnePayType(): HasOne
    {
        return $this->hasOne(PayType::class, 'ptype_id')
            ->whereNotNull('sorting')
            ->orderby('sorting');
    }
}
