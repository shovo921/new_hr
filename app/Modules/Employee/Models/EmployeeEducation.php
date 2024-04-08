<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\EducationLevel;
use App\Models\EducationExam;
use App\Models\EducationInstitute;
use App\Models\EducationSubject;

class EmployeeEducation extends Model
{
    protected $table = 'employee_educations';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;


    public function eduLevel() {
		return $this->belongsTo(EducationLevel::class, 'emp_edu_level', 'id');
	}

	public function eduExam() {
		return $this->belongsTo(EducationExam::class, 'exam', 'id');
	}

	public function group() {
		return $this->belongsTo(EducationSubject::class, 'group_subject', 'id');
	}

	public function board() {
		return $this->belongsTo(EducationInstitute::class, 'board_university', 'id');
	}
}
