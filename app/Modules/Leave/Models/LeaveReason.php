<?php

namespace App\Modules\Leave\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Database\Eloquent\Model;

use App\Modules\LeaveType\Models\LeaveType;

class LeaveReason extends Model
{
    protected $table = 'leave_reasons';
}
