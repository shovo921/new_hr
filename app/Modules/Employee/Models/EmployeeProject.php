<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeProject extends Model
{
    protected $table = 'employee_projects';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
