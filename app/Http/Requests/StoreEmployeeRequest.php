<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>'required|email',
            'employee_id'=>'required|unique:users,employee_id',
            'joining_date'=>'required',
            'personal_file_no'=>'required',
            'staff_type'=>'required',
            'mobile_no'=>'required',
            'employment_type'=>'required'
        ];
    }
}
