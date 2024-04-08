<?php

namespace App\Modules\Employee\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\Designation\Models\Designation;
use \App\Modules\Employee\Models\EmployeeDetails;
use App\User;
use Illuminate\Database\Eloquent\Model;

class EmploymentLog extends Model
{
    protected $table ='employment_log';
    public $timestamps = false;


    public function employee() {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }
    public function designationInfo(){
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    public function current_type(){
        return $this->belongsTo( EmploymentType::class, 'employment_type', 'id');
    }
    public function prev_type(){
        return $this->belongsTo( EmploymentType::class, 'prv_employment_type', 'id');
    }

}

