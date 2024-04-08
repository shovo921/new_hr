<?php

namespace App\Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;

class ApiInfo extends Model
{

    protected $table = 'api_credentials';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'token_updated_at'
    ];

}