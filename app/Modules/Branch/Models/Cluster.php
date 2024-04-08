<?php

namespace App\Modules\Branch\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Specialization\Models\Specialization;

class Cluster extends Model
{
    protected $guarded = ["id"];

    protected $table = 'cluster_info';
    
    public $timestamps = false;
}
