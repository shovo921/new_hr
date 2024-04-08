<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeKinship extends Model
{
    protected $table = 'employee_kinship_info';
	
    //protected $guarded = ["id"];
    protected $fillable = ["employee_id", "relation", "relative_employee_id", "relative_designation_id"];
    
    public $timestamps = false;
}
