<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteType extends Model
{
	protected $table = 'institute_types';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
	
}