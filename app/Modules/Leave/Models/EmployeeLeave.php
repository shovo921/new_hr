<?php

namespace App\Modules\Leave\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Database\Eloquent\Model;

use App\Modules\LeaveType\Models\LeaveType;

class EmployeeLeave extends Model
{
    protected $table = 'employee_leave_infos';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

    public function leaveType() {
		return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
	}
    public function employeeName() {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }
}
