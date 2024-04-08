<?php

namespace App\Modules\EmployeePromotion\Models;
use App\Modules\Designation\Models\Designation;
use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Database\Eloquent\Model;

class EmployeePromotion extends Model
{
    protected $table = 'employee_promotion';
    public $incrementing = false;
    protected $guarded =[];
    protected $fillable = ['employee_id', 'previous_des_id', 'promoted_des_id', 'promoted_inc_slave_no', 'created_by',
        'created_date', 'promotion_date', 'authorize_status', 'authorized_by', 'authorized_date'];


    public $timestamps = false;
    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id', 'employee_id');
    }

    public function pre_designation()
    {
        return $this->belongsTo(Designation::class, 'previous_des_id', 'id');
    }

    public function prom_designation()
    {
        return $this->belongsTo(Designation::class, 'promoted_des_id', 'id');
    }

}