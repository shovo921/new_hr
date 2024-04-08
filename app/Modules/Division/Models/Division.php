<?php

namespace App\Modules\Division\Models;

use Illuminate\Database\Eloquent\Model;


class Division extends Model
{
	protected $table = 'divisions';

    protected $guarded = ["id"];
    
    public $timestamps = false;
}
