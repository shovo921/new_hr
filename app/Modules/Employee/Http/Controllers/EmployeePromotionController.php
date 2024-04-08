<?php
/**
* Purpose: This Controller Used for Employee Promotion Information Manage
* Created: Jobayer Ahmed
* Change history:
* 08/02/2021 - Jobayer
**/
namespace App\Modules\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Designation\Models\Designation;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeeSalary;
use App\Modules\Employee\Models\SalarySlave;

//use App\Models\Branch;


class EmployeePromotionController extends Controller
{

	public function __construct(){
		$_SESSION["MenuActive"] = "employee";

	}

    /**
     * Get the specified employee promotion information.
     *
     * @param int $employee_id
     * @return \Illuminate\Http\Response
     */
    public function employeePromotion($employee_id)
    {
        try {
            $EmployeeDetails = EmployeeDetails::where('employee_id', $employee_id);
            if($EmployeeDetails->count() > 0) {
                $EmployeeDetailsInfo = $EmployeeDetails->first();

                $designation_id = $EmployeeDetailsInfo->designation_id;

                $incrementSlave = array(
                    "0" => "0",
                    "1" => "1",
                    "2" => "2",
                    "3" => "3",
                    "4" => "4",
                    "5" => "5",
                    "6" => "6",
                    "7" => "7",
                    "8" => "8",
                    "9" => "9",
                    "10" => "10",
                    "11" => "11",
                    "12" => "12",
                    "13" => "13",
                    "14" => "14",
                    "15" => "15",
                    "16" => "16",
                    "17" => "17",
                    "18" => "18",
                    "19" => "No Scale"

                );

                $employeeSalaryData = null;
                $salaryBasicInfo = null;

                $employeeSalaryInfo = EmployeeSalary::where('employee_id', $employee_id);

                if($employeeSalaryInfo->count() > 0) {
                    $employeeSalaryData = $employeeSalaryInfo->first();
                }

                $salaryBasic = SalarySlave::where('designation_id', $designation_id);

                if($salaryBasic->count() > 0) {
                    $salaryBasicInfo = $salaryBasic->first();
                }

                $designations = $this->makeDD(Designation::pluck('designation', 'id'));

                return view('Employee::promotion',compact('EmployeeDetailsInfo', 'designations', 'incrementSlave', 'employeeSalaryData', 'salaryBasicInfo'));
            } else {
                return redirect()->back()->with('msg-error', 'Employee Information not Found.');
            }
        } catch(\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }
}
