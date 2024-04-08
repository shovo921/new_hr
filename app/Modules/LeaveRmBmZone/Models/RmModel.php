<?php

namespace App\Modules\LeaveRmBmZone\Models;

use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\EmployeePosting;
use App\Modules\Employee\Models\EmployeeVAllInfo;
use Illuminate\Database\Eloquent\Model;


class RmModel extends Model
{
    protected $table = 'RM_LIST';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
    public function postingEmloyee(){
        return $this->belongsTo(EmployeePosting::class, 'posting_id', 'id');
    }
    public function EmloyeeInfo(){
        return $this->belongsTo(EmployeeVAllInfo::class, 'posting_id', 'POSTING_ID');
    }

    public function Zone(){
        return $this->belongsTo(Zone::class, 'zone', 'id');
    }








}
