<?php

namespace App\Modules\LeaveRmBmZone\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\EmployeePosting;
use App\Modules\Employee\Models\EmployeeVAllInfo;
use Illuminate\Database\Eloquent\Model;


class BrBom extends Model
{
    protected $table = 'BR_BOM_LIST';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
    public function posting(){
        return $this->belongsTo(EmployeePosting::class, 'posting_id', 'id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    public function EmloyeeInfo(){
        return $this->belongsTo(EmployeeVAllInfo::class, 'posting_id', 'POSTING_ID');
    }


}
