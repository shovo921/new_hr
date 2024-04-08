<?php

namespace App\Modules\Leave\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\LeaveType\Models\LeaveType;

class LeaveApplicationDetails extends Model
{
    protected $table = 'leave_applications_details';
}
