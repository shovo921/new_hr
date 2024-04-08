<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class ForgetPasswordRequests extends Model
{
    protected $table = 'password_request';
    public $timestamps = false;

}
