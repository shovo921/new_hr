<?php

namespace App\Modules\ProfessionalInstitue\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalInstitue extends Model
{
    protected $table = 'professional_institutes';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;
}
