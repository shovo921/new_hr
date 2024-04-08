<?php

namespace App\Modules\DisciplinaryAction\Models;

use Illuminate\Database\Eloquent\Model;

use BetaPeak\Auditing\Drivers\FilesystemDriver;
use App\User;
use App\Modules\DisciplinaryCategory\Models\DisciplinaryCategory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class DisciplinaryActionHistory extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
	protected $table = 'disciplinary_action_history';

    protected $guarded = ['id'];
    
    public $timestamps = false;

    /**
     * Filesystem Audit Driver
     *
     * @var BetaPeak\Auditing\Drivers\Filesystem
     */
    protected $auditDriver = FilesystemDriver::class;


    public function employee() {
		return $this->belongsTo(User::class, 'employee_id', 'employee_id');
	}
    public function disciplinaryCategory() {
		return $this->belongsTo(DisciplinaryCategory::class, 'dis_categorie_id', 'id');
	}
}
