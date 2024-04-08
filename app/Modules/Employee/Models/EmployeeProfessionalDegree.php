<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\ProfessionalInstitue\Models\ProfessionalInstitue;

class EmployeeProfessionalDegree extends Model
{
    protected $table = 'employee_professional_degree';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

	public function profInstitue() {
		return $this->belongsTo(ProfessionalInstitue::class, 'institute_name', 'id');
	}
}
