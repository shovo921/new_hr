<?php

namespace App\Modules\SalaryHead\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryHead extends Model
{
    //
    protected $table = 'salary_heads';
    protected $guarded = ['id'];
    public $timestamps = false;
}
