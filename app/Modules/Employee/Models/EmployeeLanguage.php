<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLanguage extends Model
{
    protected $table = 'employee_languages';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
