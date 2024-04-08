<?php

namespace App\Modules\Designation\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Division\Models\Division;
use App\Modules\District\Models\District;

class StaffType extends Model
{
    protected $table = 'staff_types';

	protected $guarded = ['id'];
}
