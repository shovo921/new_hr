<?php

namespace App\Modules\ReportingManagers\Models;

use App\Modules\Branch\Models\Branch;
use Illuminate\Database\Eloquent\Model;

class ReportingManagers extends Model
{
    //
    protected $table = 'reporting_managers';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function branch_name(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

}
