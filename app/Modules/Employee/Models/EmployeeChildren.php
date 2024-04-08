<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeChildren extends Model
{
    protected $table = 'employee_childrens';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
