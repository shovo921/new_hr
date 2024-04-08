<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\TrainingOrganization\Models\TrainingOrganization;
use App\Modules\TrainingSubject\Models\TrainingSubject;

class EmployeeTraining extends Model
{
    protected $table = 'employee_trainings';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

	public function orgName() {
		return $this->belongsTo(TrainingOrganization::class, 'org_name', 'id');
	}
	public function subjectName() {
		return $this->belongsTo(TrainingSubject::class, 'subject', 'id');
	}
}
