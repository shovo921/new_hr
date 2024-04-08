<?php

namespace App\Modules\LeaveRmBmZone\Models;

use Illuminate\Database\Eloquent\Model;


class Zone extends Model
{
    protected $table = 'zone';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

}
