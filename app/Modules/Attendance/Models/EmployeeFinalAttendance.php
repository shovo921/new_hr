<?php

namespace App\Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeFinalAttendance extends Model
{
    protected $table = 'emp_final_attendance';
	
    // protected $guarded = ["ID"];
   /* protected $fillable = ['employee_id', 'attendance_date', 'in_time', 'node_id', 'location', 'created_at'];

    public $incrementing = false;*/
    
    public $timestamps = false;
}
