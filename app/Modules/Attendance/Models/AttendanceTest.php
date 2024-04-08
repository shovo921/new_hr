<?php

namespace App\Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceTest extends Model
{
    protected $table = 'employee_attendance_test';
	
    // protected $guarded = ["ID"];
    protected $fillable = ['employee_id', 'attendance_date', 'in_time', 'node_id', 'location', 'created_at','remarks','modify_date'];

    public $incrementing = false;
    
    public $timestamps = false;
}
