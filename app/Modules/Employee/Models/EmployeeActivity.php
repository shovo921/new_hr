<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeActivity extends Model
{
    protected $table = 'employee_activities';
	
    //protected $guarded = ["id"];
    protected $fillable = ["activity_name", "employee_id"];
    
    public $timestamps = false;
}
