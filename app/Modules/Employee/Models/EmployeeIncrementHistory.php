<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class EmployeeIncrementHistory extends Model
{
    protected $table = 'employee_increment_history';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

    public function employee() {
		return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
	}
}