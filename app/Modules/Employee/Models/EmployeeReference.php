<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeReference extends Model
{
    protected $table = 'employee_references';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
