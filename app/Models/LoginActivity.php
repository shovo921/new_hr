<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
	protected $table = 'login_activity_log';
    
    public $fillable = ['username', 'user_ip', 'purpose', 'login_date'];

    public $timestamps = false;
}