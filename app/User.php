<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\UserResolver;
use Spatie\Permission\Traits\HasRoles;
#use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable implements \OwenIt\Auditing\Contracts\Auditable, UserResolver
{
    use Notifiable,HasRoles; //,SoftDeletes;
    use Auditable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded = [];
    protected $fillable = [
        'name', 'employee_id', 'password', 'mobile_no', 'role_id','email', 'type', 'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = false;

    public static function resolve()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }
}
