<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationSubject extends Model
{
    protected $table = 'education_subjects';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
