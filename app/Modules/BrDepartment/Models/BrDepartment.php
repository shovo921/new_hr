<?php

namespace App\Modules\BrDepartment\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\Branch\Models\Branch;

class BrDepartment extends Model
{
    protected $guarded = ['id'];

    public function branch() {
      return $this->belongsTo(Branch::class, 'br_id','id');
    }

    public function division() {
        return $this->belongsTo(BrDivision::class, 'div_id','id');
      }
}
