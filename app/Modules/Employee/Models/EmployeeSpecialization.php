<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Specialization\Models\Specialization;

class EmployeeSpecialization extends Model
{
    protected $table = 'employee_specializations';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

    public function specialize() {
		return $this->belongsTo(Specialization::class, 'specialization_area', 'id');
	}
}
