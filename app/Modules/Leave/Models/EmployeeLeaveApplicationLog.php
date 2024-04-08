<?php

namespace App\Modules\Leave\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\LeaveType\Models\LeaveType;

class EmployeeLeaveApplicationLog extends Model
{
    protected $table = 'leave_applications_log';
    public $incrementing = false;
    protected $fillable = ['leave_id','leave_reliever','remarks','updated_at'];
    public $timestamps = false;


}
