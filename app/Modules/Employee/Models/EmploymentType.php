<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    protected $table = 'employment_types';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}