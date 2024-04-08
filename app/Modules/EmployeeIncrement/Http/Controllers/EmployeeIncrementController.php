<?php
/**
 * Purpose: This Controller Used for Employee Increment Information Manage
 * Created: Jobayer Ahmed
 * Change history:
 * 06/09/2021 - Jobayer
 **/

namespace App\Modules\EmployeeIncrement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\Designation\Models\Designation;
use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeeIncrementHistory;
use App\Modules\Employee\Models\EmployeeSalary;
use App\Modules\Employee\Models\SalaryIncrementSlave;
use App\Modules\Employee\Models\SalarySlave;
use App\Modules\EmployeeIncrement\Http\Imports\IncrementFileImport;
use App\Modules\EmployeeIncrement\Models\EmployeeSalaryTemp;
use App\Modules\EmployeeIncrement\Models\IncrementFile;
use App\Modules\EmployeeIncrement\Models\SalaryDedSlip;
use App\Modules\EmployeeIncrement\Models\SalaryPaySlip;
use App\Modules\EmployeePromotion\Models\EmployeePromotion;
use App\Modules\EmployeePromotion\Models\EmployeePromotionTemp;
use App\Modules\SalaryHead\Models\SalaryHead;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;


class EmployeeIncrementController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "increment";
    }

    /**
     * Display the module welcome screen
     *
     * @return Response
     */
    public function create()
    {
        $_SESSION["SubMenuActive"] = "employee-increment";

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

        $salaryIncrementSlave = SalaryIncrementSlave::all();
        $lastIncrementInfo = EmployeeIncrementHistory::first();


        return view("EmployeeIncrement::create", compact('employeeList', 'lastIncrementInfo', 'incrementSlave', 'salaryIncrementSlave'));
    }

    public function addIncrementHistory($employee_id, $updatedSlab, $incrementDate, $request)
    {
        /** Salary History **/
        $salaryHistory = [
            'employee_id' => $employee_id,
            'inc_slave_no' => $updatedSlab,
            'increment_date' => date('Y-m-d', strtotime($incrementDate)),
            'created_by' => auth()->user()->id,
            'authorize_status' => 2,
            'created_date' => date('m/d/Y H:i:s')];


        $saUpdate = EmployeeSalary::where('employee_id', $employee_id)->first();
        $employeeIncrementHistory = EmployeeIncrementHistory::where('employee_id', $employee_id)
            ->where('authorize_status', 2)->first();
        if (empty($employeeIncrementHistory)) {
            $addIncrement = new EmployeeIncrementHistory();
            $addIncrement->fill($salaryHistory)->save();
        } else {
            $employeeIncrementHistory->fill($salaryHistory)->update();
        }


        /** Employee Salary **/
        $salaryData = (json_decode($request['salary_info'])->sal);
        $updatedSalInfo = array_merge((array)$salaryData, [
            'authorize_status' => 2,
            'updated_by' => auth()->user()->id,
            'updated_at' => date('m/d/Y H:i:s')
        ]);

        $saUpdate->fill($updatedSalInfo)->update();

        return redirect()->back()->with('msg-success', 'Employee Increment Added');
    }

    /**
     * Update the specified employee salary increment.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function employeeSalaryStore(Request $request): RedirectResponse
    {
        try {
            \DB::beginTransaction();

            $inputs = $request->all();


            $inc_slab = $inputs['current_inc_slave'];
            $employee_id = $inputs['employee_id'];

            $salaryInfo['employee_id'] = $employee_id;
            $salaryInfo['current_basic'] = $inputs['current_basic'];
            $salaryInfo['consolidated_salary'] = $inputs['consolidated_amount'];
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
            $salaryInfo['updated_by'] = auth()->user()->id;
            $salaryInfo['updated_at'] = date('m/d/Y H:i:s');
            $salaryInfo['consolidated_flag'] = $inputs['consolidated_flag'];

            $employeeSalary = EmployeeSalary::where('employee_id', $employee_id);


            $salaryInfo['authorize_status'] = '2';
            EmployeeSalaryTemp::create($salaryInfo);

            if ($employeeSalary->count() == 0) {

                EmployeeSalary::create($salaryInfo);

                $salaryHistory['authorize_status'] = '2';
                $msg = 'Employee Salary Information Successfully Updated.';
            } else {
                $msg = 'Employee increment request has been submitted waiting for authorization';
                $salaryHistory['authorize_status'] = '2';
            }

            $lastIncrementInfo = EmployeeIncrementHistory::where('employee_id', $employee_id)->where('authorize_status', '2');
            if ($lastIncrementInfo->count() == 0) {
                $salaryHistory['employee_id'] = $employee_id;
                $salaryHistory['inc_slave_no'] = $inputs['current_inc_slave'];
                $salaryHistory['increment_date'] = $inputs['increment_date'];
                $salaryHistory['created_by'] = auth()->user()->id;
                $salaryHistory['created_date'] = date('m/d/Y H:i:s');

                EmployeeIncrementHistory::create($salaryHistory);
                \DB::commit();

                return redirect()->back()->with('msg-success', $msg);
            } else {
                return redirect()->back()->with('msg-error', 'Employee Increment Waiting for Authorization.');
            }
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


    /**
     * Get the Employee Current Salary Information
     *
     * @return Response
     */
    public function getEmployeeCurrentSalaryInfo(Request $request)
    {

        try {
            $employee_id = $request->employee_id;


            $employeeDetails = EmployeeDetails::where('employee_id', $employee_id);
            if ($employeeDetails->count() > 0) {
                $employeeDetailsInfo = $employeeDetails->first();


                $designation_id = $employeeDetailsInfo->designation_id;

                $response = array();
                $employeeInfo = array();
                $employeeSalaryData = array();

                $employeeInfo['emp_name'] = $employeeDetailsInfo->employee_name;
                $employeeInfo['emp_designation'] = $employeeDetailsInfo->designationInfo->designation;
                $employeeInfo['designation_id'] = $designation_id;


                $employeeSalaryInfo = EmployeeSalary::where('employee_id', $employee_id)->first();
                $salaryBasic = SalarySlave::where('designation_id', $designation_id);
                $curSalaryIncrementSlaveList = SalaryIncrementSlave::where('designation_id', $designation_id)->where('inc_slave_no', 0)->get();
                //dd(!empty($employeeSalaryInfo),$employeeSalaryInfo);

                if (!empty($employeeSalaryInfo)) {
                    $employeeSalaryData = $employeeSalaryInfo;
                } else {

                    $salaryBasicInfo = $salaryBasic->first();
                    foreach ($curSalaryIncrementSlaveList as $curSalaryIncrementSlave) {
                        $employeeSalaryData['basic_salary'] = $curSalaryIncrementSlave->basic_salary;
                        $employeeSalaryData['current_inc_slave'] = ($curSalaryIncrementSlave->inc_slave_no);
                        $employeeSalaryData['medical'] = $salaryBasicInfo->medical;
                        $employeeSalaryData['conveyance'] = $salaryBasicInfo->conveyance;
                        $employeeSalaryData['house_maintenance'] = $salaryBasicInfo->house_maintenance;
                        $employeeSalaryData['utility'] = $salaryBasicInfo->utility;
                        $employeeSalaryData['lfa'] = $salaryBasicInfo->lfa;
                        $employeeSalaryData['car_maintenance'] = $salaryBasicInfo->car_allowance;
                        $employeeSalaryData['consolidated_salary'] = $salaryBasicInfo->consolidated_salary;

                    }
                }


                if ($salaryBasic->count() > 0) {
                    $salaryBasicInfo = $salaryBasic->first();
                }


                $response['employeeInfo'] = $employeeInfo;
                $response['employeeSalaryData'] = $employeeSalaryData;
                $response['employeeDesigSlav'] = $salaryBasicInfo;


                echo json_encode($response);
            }
        } catch (\Exception $e) {
            echo '';
        }
    }

    /**
     * Authorization list of employee salary increment.
     *
     * @return Response
     */
    public function incrementAuthorization()
    {
        try {
            $incrementHistoryInfo = array();

            $incrementHistory = EmployeeIncrementHistory::where('authorize_status', '2');
            if ($incrementHistory->count() > 0) {
                $incrementHistoryInfo = $incrementHistory->get();
            }
            /*return view('EmployeeIncrement::increment_auth', compact('incrementHistoryInfo'));*/
            return view('EmployeeIncrement::increment_auth', compact('incrementHistoryInfo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * View Salary Increment Authorization View Modal.
     *
     * @param int $id
     * @return Application|Factory|RedirectResponse|View
     */
    public function authorizedIncrementView(Request $request)
    {
        try {
            $salaryIncrementSlave = EmployeeSalaryTemp::where('employee_id', $request->employee_id)->orderby('created_at', 'DESC')->first();
            return view("EmployeeIncrement::salOrIncrementAuth", compact('salaryIncrementSlave'));
        } catch (\Exception $e) {

            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }


    /**
     * Authorize the specified employee salary increment.
     *
     * @param $employee_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function authorizedIncrement($employee_id)
    {
        try {
            \DB::beginTransaction();


            $employeeDetail = EmployeeDetails::where('employee_id', $employee_id)->first();
            $promotionInfo = EmployeePromotion::where('employee_id', $employee_id)->first();
            $lastIncrementInfo = EmployeeIncrementHistory::where('employee_id', $employee_id)
                ->where('authorize_status', '2')
                ->first();


            $salaryIncrementSlave = EmployeeSalaryTemp::where('employee_id', $employee_id)->where('authorize_status', '2')
                ->orderby('created_at', 'DESC')->first();

            $salarySlave = salarySlave::where('designation_id', $employeeDetail->designation_id)->first();

            $new_basic_salary = $salaryIncrementSlave->current_basic;
            $new_house_rent = $salaryIncrementSlave->house_rent;
            $gross_total_amount = ((int)$new_basic_salary + (int)$new_house_rent + (int)$salaryIncrementSlave->medical + (int)$salaryIncrementSlave->conveyance + (int)$salaryIncrementSlave->house_maintenance + (int)$salaryIncrementSlave->utility + $salaryIncrementSlave->lfa + $salaryIncrementSlave->others);


            $salaryInfo['employee_id'] = $employee_id;
            $salaryInfo['current_basic'] = (int)$new_basic_salary;
            $salaryInfo['consolidated_salary'] = (int)$salaryIncrementSlave->consolidated_salary;
            $salaryInfo['consolidated_flag'] = (int)$salaryIncrementSlave->consolidated_flag;
            $salaryInfo['car_maintenance'] = (int)$salaryIncrementSlave->car_allowance;
            $salaryInfo['house_rent'] = (int)$salaryIncrementSlave->house_rent;
            $salaryInfo['medical'] = (int)$salaryIncrementSlave->medical;
            $salaryInfo['conveyance'] = (int)$salaryIncrementSlave->conveyance;
            $salaryInfo['house_maintenance'] = (int)$salaryIncrementSlave->house_maintenance;
            $salaryInfo['utility'] = (int)$salaryIncrementSlave->utility;
            $salaryInfo['lfa'] = (int)$salaryIncrementSlave->lfa;
            $salaryInfo['others'] = (int)$salaryIncrementSlave->others;
            $salaryInfo['pf'] = (($new_basic_salary * 10) / 100);
            $salaryInfo['gross_total'] = $gross_total_amount;
            $salaryInfo['current_inc_slave'] = $lastIncrementInfo->inc_slave_no;
            $salaryInfo['updated_by'] = auth()->user()->id;
            $salaryInfo['updated_at'] = date('m/d/Y H:i:s');
            $salaryInfo['authorize_status'] = '1';

            //dd($salaryInfo);

            EmployeeSalary::where('employee_id', $employee_id)->update($salaryInfo);

            $salaryHistory['authorize_status'] = '1';
            $salaryHistory['authorized_by'] = auth()->user()->id;
            $salaryHistory['authorized_date'] = date('d-M-Y');
            $sal_temp = array(
                'updated_by' => auth()->user()->id,
                'updated_at' => $salaryInfo['updated_at'],
                'authorize_status' => '1',
                'authorize_by' => auth()->user()->id,
                'authorize_date' => date('d-M-Y')
            );

            /**
             * This is an initial state while setting the salary of the employee
             */

            $promotionData['employee_id'] = $employee_id;
            $promotionData['previous_des_id'] = $employeeDetail->designation_id;
            $promotionData['promoted_des_id'] = $employeeDetail->designation_id;
            $promotionData['promoted_inc_slave_no'] = $salaryIncrementSlave->current_inc_slave;
            $promotionData ['created_by'] = auth()->user()->id;
            $promotionData ['promotion_date'] = date('Y-m-d');
            $promotionData ['authorize_status'] = 1;
            $promotionData['authorized_by'] = auth()->user()->id;
            $promotionData ['authorized_date'] = date('Y-m-d');


            if (empty($promotionInfo)) {
                EmployeePromotion::create($promotionData);
            }


            EmployeeSalaryTemp::where('id', $salaryIncrementSlave->id)->update($sal_temp);
            EmployeeIncrementHistory::where('employee_id', $employee_id)->where('authorize_status', '2')->update($salaryHistory);


            \DB::commit();
            return redirect()->to('incrementAuthorization')->with('msg-success', 'Employee Increment Successfully Authorized.');
            //return view('EmployeeIncrement::emp_sal_list',compact('allEmployees'))->with('msg-success', 'Employee Increment Successfully Authorized.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Cancel the specified employee salary increment.
     *
     * @param Request $request
     * @return Response
     */
    public function cancelIncrement($employee_id)
    {
        try {
            \DB::beginTransaction();


            $salaryHistory['authorize_status'] = '3';
            $salaryHistory['authorized_by'] = auth()->user()->id;
            $salaryHistory['authorized_date'] = date('Y-m-d');
            EmployeeIncrementHistory::where('employee_id', $employee_id)->where('authorize_status', '2')->update($salaryHistory);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Increment Canceled.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Display the employee salary certificate screen
     *
     * @return Response
     */
    public function salaryCertificate()
    {
        $_SESSION["SubMenuActive"] = "salary-certificate";

        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $employeeList = $this->makeDD($employeeData);

        return view("EmployeeIncrement::salary-certificate", compact('employeeList'));
    }

    /**
     * Generate employee salary certificate
     *
     * @return Response
     */
    public function generateSalaryCertificate(Request $request)
    {
        $_SESSION["SubMenuActive"] = "salary-certificate";

        try {
            $employee_id = $request->employee_id;

            $employeeDetails = EmployeeDetails::where('employee_id', $employee_id);
            if ($employeeDetails->count() > 0) {
                $employeeInfo = $employeeDetails->first();

                $designation_id = $employeeInfo->designation_id;


                $response = array();
                // $employeeInfo = array();
                $employeeSalaryData = array();


                $employeeSalaryInfo = EmployeeSalary::where('employee_id', $employee_id);

                if ($employeeSalaryInfo->count() > 0) {
                    $employeeSalaryData = $employeeSalaryInfo->first();
                }

                $salaryBasic = SalarySlave::where('designation_id', $designation_id);

                if ($salaryBasic->count() > 0) {
                    $salaryBasicInfo = $salaryBasic->first();
                }

                $salaryHeads = SalaryHead::where('salary_cert_status', '1')->orderBy('serial_no', 'asc')->get();

                return view("EmployeeIncrement::certificate", compact('employeeInfo', 'employeeSalaryData', 'salaryBasicInfo', 'salaryHeads'));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function employeeSalaryCertificate()
    {
        $_SESSION["SubMenuActive"] = "salary-certificate";

        try {
            $employee_id = auth()->user()->employee_id;

            $employeeDetails = EmployeeDetails::where('employee_id', $employee_id);
            if ($employeeDetails->count() > 0) {
                $employeeInfo = $employeeDetails->first();

                $designation_id = $employeeInfo->designation_id;


                $response = array();
                // $employeeInfo = array();
                $employeeSalaryData = array();

                // $employeeInfo['employee_name'] = $employeeDetailsInfo->employee_name;
                // $employeeInfo['emp_designation'] = $employeeDetailsInfo->designationInfo->designation;
                // $employeeInfo['designation_id'] = $designation_id;


                $employeeSalaryInfo = EmployeeSalary::where('employee_id', $employee_id);

                if ($employeeSalaryInfo->count() > 0) {
                    $employeeSalaryData = $employeeSalaryInfo->first();
                }

                $salaryBasic = SalarySlave::where('designation_id', $designation_id);

                if ($salaryBasic->count() > 0) {
                    $salaryBasicInfo = $salaryBasic->first();
                }

                $salaryHeads = SalaryHead::where('salary_cert_status', '1')->orderBy('serial_no', 'asc')->get();

                /*$response['employeeInfo'] = $employeeInfo;
                $response['employeeSalaryData'] = $employeeSalaryData;
                $response['employeeDesigSlav'] = $salaryBasicInfo;
                echo '<pre>';
                print_r($response);
                echo '</pre>';
                exit();*/
                /*echo json_encode($response);*/

                return view("EmployeeIncrement::certificate", compact('employeeInfo', 'employeeSalaryData', 'salaryBasicInfo', 'salaryHeads'));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function allEmpSal(Request $request)
    {
        $_SESSION['SubMenuActive'] = 'all-salary';

        $allEmployeeSalary = $this->__allEmpSalaryFilter($request);

        $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $branchList = $this->makeDD(Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')->pluck('branch_name', 'branch'));
        $designationList = $this->makeDD(Designation::select(DB::raw("(designation) designation_name"), 'id as designation_id')->orderby('seniority_order')->pluck('designation_name', 'designation_id'));

        return view("EmployeeIncrement::emp_sal_list", compact('allEmployeeSalary', 'allEmployees', 'branchList', 'designationList'));
    }

    private function __allEmpSalaryFilter($request)
    {
        $allEmployeeSalary = EmployeeSalary::select('employee_salary.*')
            ->join('employee_details as ed', 'employee_salary.employee_id', '=', 'ed.employee_id')
            ->where('ed.status', '=', '1');

        if ($request->filled('employee_id')) {
            $allEmployeeSalary->where('employee_salary.employee_id', $request->employee_id);
        }

        if ($request->filled('branch')) {
            $allEmployeeSalary->where('ed.branch_id', $request->branch);
        }

        if ($request->filled('designation_id')) {
            $allEmployeeSalary->where('ed.designation_id', $request->designation_id);
        }

        return $allEmployeeSalary->orderBy('ed.employee_id', 'asc')->paginate(10);
    }

    /**
     * This function is for showing promotion history.
     *
     * @param $employee_id
     * @return RedirectResponse
     */
    function allEmployeePromotionHistory($employee_id)
    {

        $promotionHistoryList = EmployeePromotion::where('employee_id', $employee_id)
            ->orderby(DB::raw("TO_DATE(PROMOTION_DATE, 'YYYY-MM-DD')"), 'DESC')
            ->get();

        return view("EmployeeIncrement::employee_promotion_history", compact('promotionHistoryList'));
    }

    /**
     * This function is for employee salary detailed view.
     *
     * @param $employee_id
     * @return RedirectResponse
     */

    function detailEmployeeSalary($employee_id)
    {
        $employeeSalary = EmployeeSalary::where('employee_id', $employee_id)->first();
        $salaryPaySlips = SalaryPaySlip::where('emp_id', $employee_id)->get();
        $salaryDedSlips = SalaryDedSlip::where('emp_id', $employee_id)->get();

        $payTotal = 0.00;
        $dedTotal = 0.00;
        foreach ($salaryPaySlips as $salaryPaySlip) {
            $payTotal += (float)$salaryPaySlip->amount;
        }


        foreach ($salaryDedSlips as $salaryDedSlip) {
            $dedTotal += (float)$salaryDedSlip->rate;
        }

        return view("EmployeeIncrement::view_salary_details", compact('employeeSalary', 'salaryPaySlips', 'salaryDedSlips', 'payTotal', 'dedTotal'));
    }

    public function bulkList()
    {
        $data['bulkIncrement'] = IncrementFile::get();
        return view("EmployeeIncrement::bulklist", compact('data'));
    }

    public function employeeIncrementedSalary($employeeId, $designationId, $updatedSlab)
    {
        $salaryBasic = SalarySlave::where('designation_id', $designationId)->first();
        $updatedSlabList = SalaryIncrementSlave::where('designation_id', $designationId)->where('inc_slave_no', $updatedSlab)->get();
        if (!empty($salaryBasic) || !empty($updatedSlabList)) {
            foreach ($updatedSlabList as $slabData) {

                $basic = $slabData->basic_salary;
                $gross_total_amount = ((int)$basic + ((int)$basic / 2) + (int)$salaryBasic->medical + (int)$salaryBasic->conveyance + (int)$salaryBasic->house_maintenance + (int)$salaryBasic->utility + $salaryBasic->lfa);
                $salInfo = [
                    'employee_id' => $employeeId,
                    'current_basic' => $basic,
                    'house_rent' => ($basic) / 2,
                    'current_inc_slave' => $updatedSlab,
                    'medical' => $salaryBasic->medical,
                    'conveyance' => $salaryBasic->conveyance,
                    'house_maintenance' => $salaryBasic->house_maintenance,
                    'utility' => $salaryBasic->utility,
                    'lfa' => $salaryBasic->lfa,
                    'pf' => (($basic * 10) / 100),
                    'gross_total' => $gross_total_amount
                ];
            }

        } else {
            $salInfo = [];
        }
        $incrementInfo['sal'] = empty($salInfo) ? null : $salInfo;
        return json_encode($incrementInfo, JSON_PRETTY_PRINT);

    }

    /**
     * @return RedirectResponse
     * Status = 1= Initial,2=Processing,3=Success
     */
    public function bulkListUpdate()
    {
        $data['showIncrementedList'] = IncrementFile::where('employee_id', '20210428001')->get();
        //$data['showIncrementedList'] = IncrementFile::get();
        foreach ($data['showIncrementedList'] as $incList) {
            $updateIncrementTable = IncrementFile::findOrFail($incList->id);

            if (isset($incList->employeeSalIno->current_inc_slave) && (int)$incList->employeeSalIno->current_inc_slave != 19) {
                $updatedSlab = ($incList->inc_count) + ($incList->employeeSalIno->current_inc_slave);
                $list = [
                    'employee_id' => $incList->employee_id,
                    'designation_id' => $incList->employeeInfo->designation_id,
                    'inc_count' => $incList->inc_count,
                    'current_slab' => $incList->employeeSalIno->current_inc_slave,
                    'updated_slab' => $updatedSlab,
                    'salary_info' => $this->employeeIncrementedSalary($incList->employee_id, $incList->employeeInfo->designation_id, $updatedSlab),
                    'status' => 2,
                    'remarks' => 'Increment Data Updated',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now(),
                ];

                $this->addIncrementHistory($incList->employee_id, $updatedSlab, $updateIncrementTable->increment_date, $list);
            } else {
                $list = [
                    'designation_id' => $incList->employeeInfo->designation_id,
                    'remarks' => 'Increment Not Found',
                    'status' => 1,
                    'salary_info' => '',
                    'updated_slab' => '',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now(),
                ];

            }
            $updateIncrementTable->update($list);
        }
        return redirect()->back()->with('msg-success', 'Employee Increment Information Updated');


    }

    public function authorizeBulkIncrement()
    {
        $data['incrementedInfo'] = IncrementFile::where('status', 2)->get();
        foreach ($data['incrementedInfo'] as $increment) {
            $bulkIncrement = IncrementFile::findOrFail($increment->id);
            $incrementHistory = EmployeeIncrementHistory::where('employee_id', $increment->employee_id)->where('authorize_status', 2)->first();
            $employeeSalary = EmployeeSalary::where('employee_id', $increment->employee_id)->where('authorize_status', 2)->first();

            $employeeSalaryData = [
                'authorize_status' => 1,
                'authorize_by' => auth()->user()->id,
                'authorize_date' => date('m/d/Y H:i:s'),
            ];
            $incrementHistoryData = [
                'authorize_status' => 1,
                'authorized_by' => auth()->user()->id,
                'authorized_date' => date('m/d/Y H:i:s'),
            ];

            $bulkIncrement->fill(['status' => 3])->update();
            $incrementHistory->fill($employeeSalaryData)->update();
            $employeeSalary->fill($incrementHistoryData)->update();

        }
        return redirect()->back()->with('msg-success', 'Employee Increment Information Successfully Authorized');

    }

    public function incrementedSalaryShow($id)
    {
        $data = IncrementFile::findOrFail($id);

        return response()->json([
            'amount' => json_decode($data->salary_info),
            'employee_id' => $data->employee_id,
            'employee_name' => $data->employeeInfo->employee_name,
        ]);

    }

    public function import_excel(Request $request)
    {

        // LARAVEL VALIDATION
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // GET THE UPLOADED FILE
        $file = $request->file('file');

        // RENAME THE FILE
        $nama_file = date('YmdHis') . '_' . $file->getClientOriginalName();

        // CONFIG
        $dir_path = 'uploads/increment/product';
        $destination_path = public_path($dir_path);

        // UPLOAD TO THE DESTINATION PATH ($dir_path) IN PUBLIC FOLDER
        if ($file->move($destination_path, $nama_file)) {
            // SET FLAG FOR OLD DATA
            IncrementFile::whereNull('replaced_at')
                ->update(['replaced_at' => date('Y-m-d H:i:s')]);

            // IMPORT DATA
            Excel::import(new IncrementFileImport, public_path($dir_path . '/' . $nama_file));

            // SUCCESS
            return redirect()
                ->route('admin.product.list')
                ->with('success', lang('Successfully imported data #item', $this->translation, ['#item' => $this->item]));
        }

        // FAILED
        return back()
            ->withInput()
            ->with('error', lang('Oops, failed to imported data #item. Please try again.', $this->translation, ['#item' => $this->item]));
    }

}
