<?php

namespace App\Modules\District\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Division\Models\Division;

class District extends Model
{
    protected $table = 'districts';

    protected $guarded = ["id"];
    
    public $timestamps = false;

    public function division() {
		return $this->belongsTo(Division::class, 'division_id', 'id');
	}
}
