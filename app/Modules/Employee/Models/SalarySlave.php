<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Designation\Models\Designation;

class SalarySlave extends Model
{

    protected $table = 'salary_slaves';
	
   protected $guarded = ["id"];
    
    public $timestamps = false;
    
    
   public function designation(){
    	return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
}
