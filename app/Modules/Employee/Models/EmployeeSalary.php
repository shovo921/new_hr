<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    protected $table = 'employee_salary';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

    public function employee(){
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }
}
