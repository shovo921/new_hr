<?php

namespace App\Modules\DepartmentUnit\Models;

use Illuminate\Database\Eloquent\Model;


use App\Modules\Branch\Models\Branch;
use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\BrDepartment\Models\BrDepartment;


class DepartmentUnit extends Model
{
	protected $guarded = ['id'];

	public $timestamps = false;

	public function branch() {
		return $this->belongsTo(Branch::class, 'branch_id','id');
	}

	public function division() {
		return $this->belongsTo(BrDivision::class, 'division_id','id');
	}

	public function department() {
		return $this->belongsTo(BrDepartment::class, 'department_id','id');
	}
}
