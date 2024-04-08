<?php

namespace App\Functions;


use App\Modules\EmployeeKpi\Models\KpiFields;
use Illuminate\Support\Facades\DB;

/**
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Created on 04-April-2024
 *
 */
class KpiFunction
{

    public static function singleActiveFieldGet($fieldId)
    {
        try {
            return KpiFields::select(DB::raw("(field_name) field_name"), 'id as id')
                ->where('id', $fieldId)
                ->first();
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


}