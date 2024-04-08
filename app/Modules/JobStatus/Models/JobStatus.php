<?php

namespace App\Modules\JobStatus\Models;

use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    protected $table = 'job_statuses';

    protected $guarded = ['id'];
}
