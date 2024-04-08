<?php

namespace App\Modules\BrDivision\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Branch\Models\Branch;


class BrDivision extends Model
{
    protected $guarded = ['id'];

    public function branch() {
      return $this->belongsTo(Branch::class, 'br_id', 'id');
    }
}
