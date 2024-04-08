<?php

namespace App\Modules\TrainingOrganization\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingOrganization extends Model
{
    protected $table = 'training_organization';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
