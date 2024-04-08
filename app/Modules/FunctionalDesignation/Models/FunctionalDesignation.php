<?php

namespace App\Modules\FunctionalDesignation\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionalDesignation extends Model
{
    protected $table = 'functional_designations';

	protected $guarded = ['id'];
    
    public $timestamps = false;
}
