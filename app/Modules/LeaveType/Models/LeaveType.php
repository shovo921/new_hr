<?php

namespace App\Modules\LeaveType\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Leave\Models\LeaveEligibilitie;

class LeaveType extends Model
{
    protected $table = 'leave_types';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

    public function eligibility()
    {
		return $this->belongsTo(LeaveEligibilitie::class, 'eligibility_id', 'id');
    }
}
