<?php

namespace App\Modules\Holiday\Models;

use Illuminate\Database\Eloquent\Model;


class Holiday extends Model
{
	protected $table = 'holiday';

//    protected $guarded = ["id"];
    protected $fillable = ['holiday_date', 'description'];
    public $timestamps = false;

}
