<?php

namespace App\Functions;

use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeePosting;
use App\Modules\Employee\Models\EmployeePostingHistory;
use App\Modules\Employee\Models\EmployeeVAllInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

/**
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Created on 11-Nov-2022
 *
 */
class EmployeeFunction
{
    /**
     * This will Rerun All Employee List
     * @return mixed
     */
    public static function allEmployees()
    {
        try {
            return EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->orderby(DB::raw('EMP_SENIORITY_ORDER(employee_id)'))
                ->pluck('employee_name', 'employee_id');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    /**
     * This will Rerun All Employee List
     * @return mixed
     */
    public static function allEmployeesWithResign()
    {
        try {
            return EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->orderby(DB::raw('EMP_SENIORITY_ORDER(employee_id)'))
                ->pluck('employee_name', 'employee_id');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    /**
     * This Function will Return a Single Employee
     * @param $employeeId
     * @return mixed
     */
    public static function singleEmployeeInfo($employeeId)
    {
        try {
            return EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"))
                ->where('employee_id', $employeeId)
                ->pluck('employee_name');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    /**
     * This Function will Return All Branch Employees
     * @param $branchId
     * @return mixed
     */
    public static function branchEmployees($branchId)
    {
        try {
            return EmployeeVAllInfo::select(DB::raw("(employee_id || ' - ' || employee_name || ' - ' || func_desig_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->where('branch_id', '=', $branchId)
                ->orderby('seniority')
                ->pluck('employee_name', 'employee_id');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    /**
     * This function will return only All Department Employees
     * @param $depId
     * @return mixed
     */
    public function allDepartmentEmployees($depId)
    {
        try {
            $deptEmployees = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
                ->join('employee_posting as ep', 'employee_details.employee_id', '=', 'ep.employee_id')
                ->where('ep.br_department_id', $depId)
                ->where('employee_details.status', 1)
                ->orderby(DB::raw('EMP_SENIORITY_ORDER(employee_id)'))
                ->pluck('employee_name', 'employee_id');
            return $this->makeDD($deptEmployees);
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


    /**
     * This Function will Return a Single Employee Name
     * @param $employeeId
     * @return mixed
     */
    public static function singleEmployeeName($employeeId)
    {
        try {
            return EmployeeDetails::select('employee_name')
                ->where('employee_id', $employeeId)
                ->pluck('employee_name');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public static function transferHistory($employeeId)
    {
        return EmployeePostingHistory::where('employee_id', $employeeId)->where('posting_status', 2)->first();
    }

    public static function procedureTest()
    {
        $processTest = DB::RAW("
        variable rc refcursor;
        exec PAY_SLIP('20181220001', '25-Apr-2023',:rc);
        print rc;
        ");

        return DB::select($processTest);
    }


    /**
     *
     * This function will return only the employees current Branch or Division Employees
     * @return RedirectResponse
     */
    public static function getEmployeesCurrentDivisionOrBranchMembers($employeeId)
    {
        try {

            $empBranch = EmployeePosting::select('branch_id')->where('employee_id', $employeeId)->first();
            return EmployeeVAllInfo::select(DB::raw("(employee_id || ' - ' || employee_name || ' - ' || func_desig_name) employee_name"), 'employee_id')
                ->where('branch_id', '=', $empBranch->branch_id)
                ->where('employee_id', '!=', $employeeId)
                ->where('status', 1)
                ->orderby('seniority')
                ->pluck('employee_name', 'employee_id');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


}