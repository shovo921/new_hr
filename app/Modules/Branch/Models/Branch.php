<?php

namespace App\Modules\Branch\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Specialization\Models\Specialization;
use App\Modules\Branch\Models\Cluster;

class Branch extends Model
{
    protected $guarded = ["id"];
    protected $table = 'branch';
    public $timestamps = false;

    public function parent_branch_name() {
        return $this->belongsTo(Branch::class, 'parent_branch', 'id');
    }
    public function cluster_name() {
        return $this->belongsTo(Cluster::class, 'cluster_id', 'id');
    }
}


