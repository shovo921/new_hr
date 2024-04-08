<?php

namespace App\Modules\DisciplinaryAction\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use BetaPeak\Auditing\Drivers\FilesystemDriver;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Modules\DisciplinaryCategory\Models\DisciplinaryCategory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class DisciplinaryAction extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;
	protected $table = 'disciplinary_actions';
    protected $guarded = ['id'];


    //protected $fillable=['employee_id','dis_cat_id','action_start_date','action_end_date','action_details','status','action_type','action_taken_id','start_date','end_date','remarks','created_by','created_at','updated_by','updated_at'];

    
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

    public function employeeDetails() {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }

    public function disciplinaryCategory() {
		return $this->belongsTo(DisciplinaryCategory::class, 'dis_cat_id', 'id');
	}

    public function disciplinaryPunishments() {
        return $this->belongsTo(DisciplinaryPunishments::class, 'action_taken_id', 'id');
    }


    public function disciplinaryActionAttachment() {
        return $this->belongsTo(DisciplinaryActionAttachment::class, 'id', 'dis_id');
    }
}
