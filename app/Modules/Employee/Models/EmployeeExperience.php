<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\IndustryType\Models\IndustryType;

class EmployeeExperience extends Model
{
    protected $table = 'employee_experiences';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;


    public function industryType() {
        return $this->belongsTo(IndustryType::class, 'industry_type_id', 'id');
    }
}
