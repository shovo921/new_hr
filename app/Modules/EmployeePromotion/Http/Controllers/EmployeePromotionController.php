<?php
/**
 * Purpose: This Controller Used for Employee Promotion Information Manage
 * Created: Jobayer Ahmed
 * Change history:
 * 15/09/2021 - Jobayer
 **/

namespace App\Modules\EmployeePromotion\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Designation\Models\Designation;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeePromotionHistory;
use App\Modules\Employee\Models\EmployeeSalary;
use App\Modules\Employee\Models\SalaryIncrementSlave;
use App\Modules\Employee\Models\SalarySlave;
use App\Modules\EmployeePromotion\Models\EmployeePromotion;
use App\Modules\EmployeePromotion\Models\EmployeePromotionTemp;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EmployeePromotionController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "promotion";
    }

    /**
     * Display the module welcome screen
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $_SESSION["SubMenuActive"] = "employee-promotion";

        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $employeeList = $this->makeDD($employeeData);

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

        $designations = $this->makeDD(Designation::orderBy('seniority_order')->pluck('designation', 'id'));

        return view("EmployeePromotion::create", compact('employeeList', 'designations', 'incrementSlave'));
    }

    /**
     * Update the specified employee promotion information.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function employeePromotionStore(Request $request)
    {
        try {
            \DB::beginTransaction();

            $inputs = $request->all();

            $inc_slab = $inputs['current_inc_slave'];
            $employee_id = $inputs['employee_id'];

            $salaryInfo['employee_id'] = $employee_id;
            $salaryInfo['current_basic'] = $inputs['current_basic'];
            $salaryInfo['consolidated_salary'] = $inputs['consolidated_salary'];
            $salaryInfo['car_maintenance'] = $inputs['car_allowance'];
            $salaryInfo['house_rent'] = $inputs['house_rent'];
            $salaryInfo['medical'] = $inputs['medical'];
            $salaryInfo['conveyance'] = $inputs['conveyance'];
            $salaryInfo['house_maintenance'] = $inputs['house_maintenance'];
            $salaryInfo['utility'] = $inputs['utility'];
            $salaryInfo['lfa'] = $inputs['lfa'];
            $salaryInfo['others'] = $inputs['others'];
            $salaryInfo['pf'] = (($inputs['current_basic'] * 10) / 100);
            $salaryInfo['gross_total'] = $inputs['gross_total'];
            $salaryInfo['current_inc_slave'] = $inc_slab;
            $salaryInfo['authorize_status'] = '2';
            $salaryInfo['authorize_date'] = $inputs['promotion_date'];
            $salaryInfo['created_at'] = Carbon::now();
            $salaryInfo['created_by'] = auth()->user()->id;


            EmployeePromotionTemp::create($salaryInfo);
            EmployeeSalary::where('employee_id', $employee_id)->update(['authorize_status' => '2']);

            $lastPromotion = EmployeePromotion::where('employee_id', $employee_id)->where('authorize_status', '2');
            if ($lastPromotion->count() == 0) {
                if ($inputs['previous_des_id'] != $inputs['promoted_des_id']) {
                    //Promotion History
                    $promotionHistory['employee_id'] = $employee_id;
                    $promotionHistory['previous_des_id'] = $inputs['previous_des_id'];
                    $promotionHistory['promoted_des_id'] = $inputs['promoted_des_id'];
                    $promotionHistory['promoted_inc_slave_no'] = $inputs['current_inc_slave'];
                    $promotionHistory['promotion_date'] = $inputs['promotion_date'];
                    $promotionHistory['authorize_status'] = '2';
                    $promotionHistory['created_by'] = auth()->user()->id;

                    EmployeePromotion::create($promotionHistory);

                    \DB::commit();

                    return redirect()->back()->with('msg-success', 'Employee promotion request has been submitted waiting for authorization.');
                } else {
                    return redirect()->back()->with('msg-error', 'Designation not changed for promotion.');
                }
            } else {
                return redirect()->back()->with('msg-error', 'Employee promotion request already submitted waiting for authorization.');
            }
        } catch (\Exception $e) {
            \DB::rollback();

            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


    /**
     * Get the employee promotion authorization list.
     *
     * @return Response
     */
    public function promotionAuthorization()
    {
        try {
            $promotionHistoryInfo = array();

            $promotionHistory = EmployeePromotion::where('authorize_status', '2');
            if ($promotionHistory->count() > 0) {
                $promotionHistoryInfo = $promotionHistory->get();
            }

            return view('EmployeePromotion::promotion_auth', compact('promotionHistoryInfo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Authorized the specified employee promotion information.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function authorizedPromotion($employee_id)
    {
        try {
            \DB::beginTransaction();

            $lastPromotionInfo = EmployeePromotion::where('employee_id', $employee_id)
                ->where('authorize_status', '2')
                ->first();

            $salaryPromotionSlave = EmployeePromotionTemp::where('employee_id', $employee_id)
                ->where('authorize_status', '2')
                ->orderby('created_at', 'DESC')
                ->first();

            $salarySlave = salarySlave::where('designation_id', $lastPromotionInfo->promoted_des_id)->first();

            $new_basic_salary = $salaryPromotionSlave->current_basic;
            $new_house_rent = $salaryPromotionSlave->house_rent;

            $gross_total_amount = ($new_basic_salary + $new_house_rent + $salarySlave->medical + $salarySlave->conveyance + $salarySlave->house_maintenance + $salarySlave->utility + $salarySlave->lfa + $salarySlave->others);


            /**
             * Salary Information Array
             */
            $salaryInfo['employee_id'] = $employee_id;
            $salaryInfo['current_basic'] = (int)$new_basic_salary;
            $salaryInfo['consolidated_salary'] = (int)$salaryPromotionSlave->consolidated_amount;
            $salaryInfo['car_maintenance'] = (int)$salaryPromotionSlave->car_maintenance;
            $salaryInfo['house_rent'] = (int)$salaryPromotionSlave->house_rent;
            $salaryInfo['medical'] = (int)$salaryPromotionSlave->medical;
            $salaryInfo['conveyance'] = (int)$salaryPromotionSlave->conveyance;
            $salaryInfo['house_maintenance'] = (int)$salaryPromotionSlave->house_maintenance;
            $salaryInfo['utility'] = (int)$salaryPromotionSlave->utility;
            $salaryInfo['lfa'] = (int)$salaryPromotionSlave->lfa;
            $salaryInfo['others'] = (int)$salaryPromotionSlave->others;
            $salaryInfo['pf'] = (($new_basic_salary * 10) / 100);
            $salaryInfo['gross_total'] = $gross_total_amount;
            $salaryInfo['current_inc_slave'] = $lastPromotionInfo->promoted_inc_slave_no;
            $salaryInfo['updated_by'] = auth()->user()->id;
            $salaryInfo['updated_at'] = date('m/d/Y h:i:s');
            $salaryInfo['authorize_status'] = '1';

            $employeeSalary = EmployeeSalary::where('employee_id', $employee_id);


            if ($employeeSalary->count() > 0) {
                EmployeeSalary::where('employee_id', $employee_id)->update($salaryInfo);
            } else {
                EmployeeSalary::create($salaryInfo);
            }


            /**
             * Update Promotion History
             */
            $promotionHistory['authorize_status'] = '1';
            $promotionHistory['authorized_by'] = auth()->user()->id;
            $promotionHistory ['authorized_date'] = date('Y-m-d');
            EmployeePromotion::where('employee_id', $employee_id)->where('authorize_status', '2')->update($promotionHistory);

            /**
             * Update Promotion Temp
             */
            $tempUpdate = [
                'authorize_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'updated_at' => date('m/d/Y h:i:s')
            ];
            EmployeePromotionTemp::findOrFail($salaryPromotionSlave->id)->update($tempUpdate);


            /**
             * Update Employee Designation
             */
            $designation_name = Designation::where('id', $lastPromotionInfo->promoted_des_id)->first();

            $userDetails['designation_id'] = $lastPromotionInfo->promoted_des_id;
            $userDetails['designation'] = $designation_name->designation;
            EmployeeDetails::where('employee_id', $employee_id)->update($userDetails);

            \DB::commit();
            return redirect()->to('postingAuthorization')->with('msg-success', 'Employee Promotion Successfully Authorized.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Cancel the specified employee promotion authorization.
     *
     * @param int $employee_id
     * @return Response
     */
    public function cancelPromotion($employee_id)
    {
        try {
            \DB::beginTransaction();

            $promotionHistory['authorize_status'] = '3';
            $promotionHistory['authorized_by'] = '1';
            $promotionHistory['authorized_date'] = date('Y-m-d');
            EmployeePromotion::where('employee_id', $employee_id)->where('authorize_status', '2')->update($promotionHistory);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Promotion Canceled.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * View Promotion Authorization View Modal.
     *
     * @param int $id
     * @return Response
     */
    public function authorizedPromotionView(Request $request)
    {
        $salaryPromotionSlave = EmployeePromotionTemp::where('employee_id', $request->employee_id)->orderby('created_at', 'DESC')->first();

        $promotedDesignation = EmployeePromotion::where('employee_id', $request->employee_id)->where('authorize_status', 2)->first();

        return view("EmployeePromotion::promotionAuth", compact('salaryPromotionSlave', 'promotedDesignation'));
    }

    /**
     * get the specified employee promoted salary information.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function getEmployeePromotedSalaryInfo(Request $request)
    {

        //dd($request->all());
        if ($request->incrementSlave == 19) {
            $preSalaryIncrementSlave = EmployeeSalary::where('employee_id', $request->employeeId);
        } else {
            if (empty($request->currBasic)) {
                $preSalaryIncrementSlave = EmployeeSalary::where('employee_id', $request->employeeId);
            } else {
                $preSalaryIncrementSlave = SalaryIncrementSlave::where('designation_id', $request->prev_designation_id)
                    ->where('inc_slave_no', ($request->incrementSlave));
            }

        }

        if ($preSalaryIncrementSlave->count() > 0) {


            $preSalaryIncrementSlaveData = $preSalaryIncrementSlave->first();

            if ($request->incrementSlave == 19) {
                $preBasic = $preSalaryIncrementSlaveData->current_basic;
            } else {
                $preBasic = $preSalaryIncrementSlaveData->basic_salary;
            }

            $seniority1 = Designation::where('id', $request->designation_id)->first();
            $seniority2 = Designation::where('id', $request->prev_designation_id)->first();


            $returnArray = [];
            $curSalaryIncrementSlaveList = SalaryIncrementSlave::where('designation_id', $request->designation_id)->where('basic_salary', '>', (float)$preBasic)->orderby('inc_slave_no')->first();
            $salaryBasic = SalarySlave::where('designation_id', $request->designation_id)->where('basic_salary', (float)$curSalaryIncrementSlaveList->basic_salary);


            if ($salaryBasic->count() > 0) {

                $salaryBasicInfo = $salaryBasic->first();
                if ((float)$seniority1->seniority_order < (float)$seniority2->seniority_order) {

                    if ($curSalaryIncrementSlaveList->basic_salary > $preBasic) {
                        $returnArray['new_basic'] = $curSalaryIncrementSlaveList->basic_salary;
                        $returnArray['new_inc_slave'] = ($curSalaryIncrementSlaveList->inc_slave_no);
                        $returnArray['new_medical'] = $salaryBasicInfo->medical;
                        $returnArray['new_conveyance'] = $salaryBasicInfo->conveyance;
                        $returnArray['new_house_maintenance'] = $salaryBasicInfo->house_maintenance;
                        $returnArray['new_utility'] = $salaryBasicInfo->utility;
                        $returnArray['new_lfa'] = $salaryBasicInfo->lfa;
                        $returnArray['new_car_maintenance'] = $salaryBasicInfo->car_allowance;
                        $returnArray['new_consolidated_salary'] = $salaryBasicInfo->consolidated_salary;
                    } else {
                        $returnArray = 'Selected Designation is not Higher Than Previous Designation';
                    }

                } else {
                    dd('Test1');

                    $returnArray = 'Selected Designation is not Higher Than Previous Designation';

                    /*foreach ($curSalaryIncrementSlaveList as $curSalaryIncrementSlave) {
                        $returnArray['new_basic'] = $curSalaryIncrementSlave->basic_salary;
                        $returnArray['new_inc_slave'] = ($curSalaryIncrementSlave->inc_slave_no);
                        $returnArray['new_medical'] = $salaryBasicInfo->medical;
                        $returnArray['new_conveyance'] = $salaryBasicInfo->conveyance;
                        $returnArray['new_house_maintenance'] = $salaryBasicInfo->house_maintenance;
                        $returnArray['new_utility'] = $salaryBasicInfo->utility;
                        $returnArray['new_lfa'] = $salaryBasicInfo->lfa;
                        $returnArray['new_car_maintenance'] = $salaryBasicInfo->car_allowance;
                        $returnArray['new_consolidated_salary'] = $salaryBasicInfo->consolidated_salary;
                        //dd($returnArray);
                        break;
                    }*/
                }
            }


            echo json_encode($returnArray);
        }

    }

}
