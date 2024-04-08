<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationExam extends Model
{
    protected $table = 'education_exams';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

    public function eduLevel() {
        return $this->belongsTo(EducationLevel::class, 'edu_level', 'id');
    }
}
