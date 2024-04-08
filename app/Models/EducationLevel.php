<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    protected $table = 'education_levels';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
