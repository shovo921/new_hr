<?php

namespace App\Modules\Employee\Models;

use App\Modules\Branch\Models\Branch;
use App\User;
use Illuminate\Database\Eloquent\Model;

class BrDivHead extends Model
{
    protected $table ='br_div_head';
    protected $fillable=['posting_id','branch_id','start_date','status'];
    public $timestamps = false;

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }


}