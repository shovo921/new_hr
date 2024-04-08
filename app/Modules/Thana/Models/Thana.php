<?php

namespace App\Modules\Thana\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Division\Models\Division;
use App\Modules\District\Models\District;

class Thana extends Model
{
    protected $table = 'thanas';

	protected $guarded = ['id'];
	
	// protected $fillable = ['name','division_id','district_id'];
    
    public $timestamps = false;

    public function division() {
		return $this->belongsTo(Division::class, 'division_id', 'id');
	}

	public function district() {
		return $this->belongsTo(District::class, 'district_id', 'id');
	}

}
