<?php

namespace App\Modules\Resignation\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    protected $guarded = ["id"];

    protected $table = 'resignation';
    
    public $timestamps = false;

    public function employee(){
        return $this->belongsTo(EmployeeDetails::class,'employee_id','employee_id');
    }
    public function resignCat(){
        return $this->belongsTo(ResignationCategory::class,'resign_cat_id','id');
    }
}


