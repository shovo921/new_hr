<?php

namespace App\Modules\Leave\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Database\Eloquent\Model;

use App\Modules\LeaveType\Models\LeaveType;

class LeaveAttachment extends Model
{
    protected $table = 'leave_attachment';
    protected $fillable = ['leave_id','attachment','receiving_date'];
    public $timestamps = false;
}
