<?php

namespace App\Modules\Employee\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Document\Models\Document;

class EmployeeDocument extends Model
{
    protected $table = 'employee_documents';
	
    protected $guarded = ["id"];
    
    public $timestamps = false;

    public $incrementing = false;


    public function document() {
		return $this->belongsTo(Document::class, 'document_type_id', 'id');
	}
}
