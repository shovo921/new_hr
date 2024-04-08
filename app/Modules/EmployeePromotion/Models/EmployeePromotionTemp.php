<?php

namespace App\Modules\EmployeePromotion\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Database\Eloquent\Model;

class EmployeePromotionTemp extends Model
{
    protected $table ='employee_promotion_temp';
    protected $guarded = ['$id'];
    public $timestamps = false;

    public function employee(){
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }


}