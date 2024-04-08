<?php
/**
 * Purpose: This Controller Used for Employee Information Manage
 * Created: Jobayer Ahmed
 * Change history:
 * 08/02/2021 - Jobayer
 **/

namespace App\Modules\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\EmpInfoDoc;
use App\Modules\Employee\Models\EmploymentLog;
use App\Modules\Employee\Models\EmploymentType;
use Illuminate\Http\Request;
use App\User;
use App\Modules\Designation\Models\Designation;
use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Support\Facades\DB;
use App\Exports\EmployeeExport;



use Carbon\Carbon;

use Auth;


class EmploymentLogController extends Controller
{

    public function getEmpdoc(Request $request)
    {
        $allEmployees = $this->makeDD(EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id'));

        $branchList = $this->makeDD(Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')->pluck('branch_name', 'branch'));
        $designationList = $this->makeDD(Designation::select(DB::raw("(designation) designation_name"), 'id as designation_id')->orderby('seniority_order')->pluck('designation_name', 'designation_id'));

        if ($request->filled('employee_id')) {
            session()->forget('branch');
            session()->put('employee_id', $request->employee_id);
            $employee_id=$request->employee_id;
            $results=EmpInfoDoc::where('employee_id',$employee_id)->paginate(10);

        }
        elseif ($request->filled('branch')) {
            session()->forget('employee_id');
            session()->put('branch', $request->branch);
            $results=EmpInfoDoc::where('branch_id',$request->branch)->paginate(10);

        }
        else{
            session()->forget('branch');
            session()->forget('employee_id');
            $results = EmpInfoDoc::paginate(10);
        }
        return view("Employee::employeedoc", compact('results','branchList','allEmployees','designationList'));
    }


    public function employment_log(Request $request)
    {
        if (!empty($request->employee_id))
        {
            $data=EmploymentLog::where('employee_id',$request->employee_id)->get();
        }
        else{
            $data=EmploymentLog::all();
        }


        $emp_type=EmploymentType::all();
        $allEmployees = $this->makeDD(EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id'));
        return view("Employee::employment_log", compact('allEmployees','data','emp_type'));

    }



}
