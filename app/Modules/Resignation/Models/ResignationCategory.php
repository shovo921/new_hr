<?php

namespace App\Modules\Resignation\Models;

use Illuminate\Database\Eloquent\Model;

class ResignationCategory extends Model
{
    protected $guarded = ["id"];

    protected $table = 'resign_cat';
    
    public $timestamps = false;
}
