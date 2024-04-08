<?php

namespace App\Modules\DisciplinaryAction\Models;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;
use App\User;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class DisciplinaryActionAttachment extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'disciplinary_actions_attachments';
    protected $fillable=['attachment','uploaded_at','dis_id'];
    public $timestamps = false;
    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;


}
