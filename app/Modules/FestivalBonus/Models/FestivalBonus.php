<?php

namespace App\Modules\FestivalBonus\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Payroll\Models\PayType;
use Illuminate\Database\Eloquent\Model;


class FestivalBonus extends Model
{
	protected $table = 'EMP_BONUS';
    protected $guarded = ["id"];
    public $incrementing = false;
    public $timestamps = false;

    public function bonusTypeName()
    {
        return $this->belongsTo(BonusType::class, 'bonus_type', 'id');
    }

    public function PayTypeName()
    {
        return $this->belongsTo(PayType::class, 'pay_type_id', 'ptype_id');
    }
    public function EmployeeName()
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'EMPLOYEE_ID');
    }

}
