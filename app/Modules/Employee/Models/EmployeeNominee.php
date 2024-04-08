<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeNominee extends Model
{
    protected $table = 'employee_nominees';
	
    protected $guarded = ["ID"];
    
    public $timestamps = false;
}
