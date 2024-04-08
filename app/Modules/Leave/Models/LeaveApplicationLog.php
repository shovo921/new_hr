<?php

namespace App\Modules\Leave\Models;


use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Database\Eloquent\Model;

use App\Modules\LeaveType\Models\LeaveType;
use Illuminate\Foundation\Auth\User;

class LeaveApplicationLog extends Model
{
    protected $table = 'leave_applications_log';

    public function employee() {
        return $this->belongsTo(EmployeeDetails::class, 'leave_reliever', 'employee_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'leave_reliever', 'employee_id');
    }
}
