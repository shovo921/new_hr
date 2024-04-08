<?php

namespace App\Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';
    protected $guarded = ["id"];
}
