<?php

namespace App\Modules\TrainingSubject\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSubject extends Model
{
    protected $table = 'training_subjects';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
