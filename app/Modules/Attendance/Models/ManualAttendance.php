<?php

namespace App\Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class ManualAttendance extends Model
{
    protected $table = 'employee_manual_attendance';
	
    // protected $guarded = ["ID"];
    protected $fillable = ['employee_id', 'modify_by','attendance_date','in_time','out_time','created_at','remarks','updated_at'];

    public $incrementing = false;
    
    public $timestamps = false;
}
