<?php

namespace App\Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'employee_attaendances';
	
    // protected $guarded = ["ID"];
    protected $fillable = ['employee_id', 'attendance_date', 'in_time', 'node_id', 'location', 'created_at','remarks','modify_date','verify_type'];

    public $incrementing = false;
    
    public $timestamps = false;
}
