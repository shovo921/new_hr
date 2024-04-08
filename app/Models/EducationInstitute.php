<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationInstitute extends Model
{
    protected $table = 'education_institutes';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
