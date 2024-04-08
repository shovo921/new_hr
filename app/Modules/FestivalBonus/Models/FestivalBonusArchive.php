<?php

namespace App\Modules\FestivalBonus\Models;

use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Payroll\Models\PayType;
use Illuminate\Database\Eloquent\Model;


class FestivalBonusArchive extends Model
{
	protected $table = 'EMP_BONUS_ARCHIVE';
    protected $guarded = ["id"];
    public $incrementing = false;
    public $timestamps = false;



}
