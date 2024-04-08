<?php

namespace App\Modules\EmployeeIncrement\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryTemp extends Model
{
    protected $table ='employee_salary_temp';
    protected $guarded = ['$id'];
    public $timestamps = false;

    public function employee(){
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }
}
