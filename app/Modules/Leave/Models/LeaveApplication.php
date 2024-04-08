<?php

namespace App\Modules\Leave\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\FunctionalDesignation\Models\FunctionalDesignation;
use Illuminate\Database\Eloquent\Model;
use App\Modules\LeaveType\Models\LeaveType;
use App\User;
use function Symfony\Component\Translation\t;

class LeaveApplication extends Model
{
    protected $table = 'leave_applications';

    protected $guarded = ["id"];

    public $timestamps = false;
    protected $fillable = ['employee_id', 'leave_type_id', 'start_date', 'leave_location','end_date', 'next_joining_date', 'total_days', 'reason_of_leave', 'contact_info_during_leave', 'responsible_to', 'waiting_for', 'country_name','passport_no','leave_status', 'created_at', 'updated_at'];

    public function leave_type()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'waiting_for', 'employee_id');
    }

    public function leaveReliever()
    {
        return $this->belongsTo(User::class, 'responsible_to', 'employee_id');
    }

    public function branch()
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }

    public function employeeName()
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }

    public function leaveAttachment()
    {
        return $this->belongsTo(LeaveAttachment::class, 'id', 'leave_id');
    }

}
