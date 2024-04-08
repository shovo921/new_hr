<?php

namespace App\Modules\IndustryType\Models;

use Illuminate\Database\Eloquent\Model;

class IndustryType extends Model
{
    protected $table = 'industry_types';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
