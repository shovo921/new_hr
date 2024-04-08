<?php

namespace App\Modules\Payroll\Http\Controllers;


use App\Functions\BranchFunction;
use App\Functions\EmployeeFunction;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\EmployeeSalary;
use App\Modules\EmployeeIncrement\Models\SalaryDedSlip;
use App\Modules\EmployeeIncrement\Models\SalaryPaySlip;
use App\Modules\Payroll\Models\DeductionType;
use App\Modules\Payroll\Models\PaidDay;
use App\Modules\Payroll\Models\PayType;
use App\Modules\Payroll\Models\SalaryPayDedTemp;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;


class SalaryAdjustmentController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    public function regularEmpSalary($date): array
    {
//        dd('test');
        return DB::select("
        select V.EMPLOYEE_ID,
                                TO_DATE('$date', 'YYYY-MM-DD')                  PAYMENT_DATE,
                                TO_CHAR(sysdate, 'Mon-YYYY')                       YEAR_MONTH,
                                CASE
                                    WHEN TO_DATE(V.JOINING_DATE, 'DD/MM/YYYY') < trunc(sysdate, 'MM')
                                        THEN trunc(sysdate, 'MM')
                                    ELSE TO_DATE(V.JOINING_DATE, 'DD/MM/YYYY') END DEFAULT_DATE,
                                FXN_EMP_SALARY_DAY_COUNT(V.EMPLOYEE_ID)            DAY_COUNT,
                                TO_DATE(LAST_DAY(SYSDATE))                         END_DATE,
                                1 EMP_STATUS
                         from EMPLOYEE_DETAILS V
                         WHERE FXN_EMP_STATUS_AND_TYPE(EMPLOYEE_ID) = 1 
                                AND V.EMPLOYEE_ID not in (select EMPLOYEE_ID from EMP_STOP_SAL where STATUS in (4))
                           --AND EMPLOYEE_ID='20230206001'
                           ");
    }

    public function resignedEmpSalary($date): array
    {
        $firstAndLastDay = DB::Select("select trunc(sysdate, 'MM') firstDay,LAST_DAY(SYSDATE) lastDay from dual");
        $firstDay = date('Y-m-d', strtotime($firstAndLastDay[0]->firstday));
        $lastDay = date('Y-m-d', strtotime($firstAndLastDay[0]->lastday));
        return DB::select("
                                select V.EMPLOYEE_ID,
                                 TO_DATE('$date', 'YYYY-MM-DD')                  PAYMENT_DATE,
                                 TO_CHAR(sysdate, 'Mon-YYYY')                              YEAR_MONTH,
                                 trunc(sysdate, 'MM')              DEFAULT_DATE,
                                 CAST(TO_DATE(TO_CHAR(RELEASE_DATE), 'DD-MM-YYYY')-trunc(sysdate, 'MM')
                                       as INT)+1 DAY_COUNT,
                                 TO_DATE(TO_CHAR(RELEASE_DATE), 'DD-MM-YYYY')                                END_DATE,
                                 2 EMP_STATUS
                          from RESIGNATION V
                          WHERE FXN_EMP_STATUS_AND_TYPE(EMPLOYEE_ID)=2
                            AND V.STATUS=1
                            AND V.EMPLOYEE_ID not in (select EMPLOYEE_ID from EMP_STOP_SAL where STATUS in (4))
                          AND TO_DATE(TO_CHAR(RELEASE_DATE), 'DD-MM-YYYY') between '$firstDay' and '$lastDay'
                          ");
    }

    public function allFunctions(): array
    {
        $data['allEmployees'] = EmployeeFunction::allEmployees();
        $data['allBranches'] = BranchFunction::allBranches();
        $data['activeBranches'] = BranchFunction::activeOrInactiveBranches(1);
        $data['inactiveBranches'] = BranchFunction::activeOrInactiveBranches(2);
        $data['branch'] = BranchFunction::headOfficeOrBranch(2);
        $data['empCondition'] = array(
            '' => 'Please Select',
            '1' => 'Regular',
            '2' => 'Resigned',
        );
        $data['hoOrBranchOrBoth'] = [
            '' => 'Please Select',
            '1' => 'Regular(HO+BR)',
            '2' => 'Managing Director',
            '3' => 'Festival Bonus'

        ];
        return $data;
    }

    public function salFunctions($empCondition, $date): ?array
    {

        $paidDayTableCheck = PaidDay::where([['payment_date', $date], ['emp_status', $empCondition]])->get();

        if ($empCondition == 1) {
            if (isset($paidDayTableCheck)) {
                $dataSet['regularEmpSalary'] = $this->regularEmpSalary($date);
            } else {
                $dataSet['regularEmpSalary'] = $paidDayTableCheck->toarray();
            }

        } else {
            if (isset($paidDayTableCheck)) {
                $dataSet['resignedEmpSalary'] = $this->resignedEmpSalary($date);
            } else {
                $dataSet['resignedEmpSalary'] = $paidDayTableCheck->toarray();
            }
        }
        return empty($dataSet) ? null : $dataSet;
    }

    /**
     * Display the module welcome screen
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {

        $_SESSION["SubMenuActive"] = "payroll-salary-process";
        $employeeList = EmployeeFunction::allEmployees();

        return view('Payroll::SalaryAdjustment/index', compact('employeeList'));

    }
    public function show($employee_id)
    {
        $paytypedata=SalaryPayDedTemp::where('employee_id',$employee_id)->where('pay_or_ded_type',1)->get();
        $dedtypedata=SalaryPayDedTemp::where('employee_id',$employee_id)->where('pay_or_ded_type',2)->get();

        $payHeadData = PayType::select(DB::raw("(description) description"), 'ptype_id')
            ->where('status', "A")
            ->pluck('description', 'ptype_id');
        $payHeadLists = $this->makeDD($payHeadData);

        $dedTypeDatas = DeductionType::select('DTYPE_ID', 'DESCRIPTION')
            ->whereNotIn('status', ['L'])
            ->get();
        $payHeadTypeDatas = PayType::select('PTYPE_ID', 'DESCRIPTION')
            ->whereNotNull('sorting')
            ->get();

        $employeeSalary = EmployeeSalary::where('employee_id', $employee_id)->first();
        $salaryPaySlips = SalaryPaySlip::where('emp_id', $employee_id)->get();
        $salaryDedSlips = SalaryDedSlip::where('emp_id', $employee_id)->get();

        $payTotal = 0.00;
        $dedTotal = 0.00;
        foreach ($paytypedata as $salaryPaySlip) {
            $payTotal += (float)$salaryPaySlip->pay_amount;
        }

        foreach ($dedtypedata as $salaryDedSlip) {
            $dedTotal += (float)$salaryDedSlip->pay_amount;
        }
        $PaidDay=PaidDay::where('EMPLOYEE_ID',$employee_id)->first();



        return view('Payroll::SalaryAdjustment/index', compact('employeeSalary', 'salaryPaySlips', 'salaryDedSlips', 'payTotal', 'dedTotal','payHeadData', 'payHeadLists', 'dedTypeDatas', 'payHeadTypeDatas','paytypedata','dedtypedata','PaidDay'));
    }


    public function editPayDedHead($employee_id, $pay_or_ded_type,$id)
    {

        if ($pay_or_ded_type ==1)
        {
            $salaryPaySlips = SalaryPayDedTemp::select('EMP_SAL_PAY_DED_TEMP.EMPLOYEE_ID', 'EMP_SAL_PAY_DED_TEMP.type_id', 'EMP_SAL_PAY_DED_TEMP.pay_amount', 'EMP_SAL_PAY_DED_TEMP.pay_type', 'PAY_TYPE.description')
                ->join('PAY_TYPE', 'EMP_SAL_PAY_DED_TEMP.type_id', '=', 'PAY_TYPE.ptype_id')
                ->where('EMP_SAL_PAY_DED_TEMP.EMPLOYEE_ID', $employee_id)
                ->where('EMP_SAL_PAY_DED_TEMP.type_id', $id)
                ->where('EMP_SAL_PAY_DED_TEMP.pay_or_ded_type', $pay_or_ded_type)
                ->first();
        }
        else{
            $salaryPaySlips = SalaryPayDedTemp::select('EMP_SAL_PAY_DED_TEMP.EMPLOYEE_ID', 'EMP_SAL_PAY_DED_TEMP.type_id', 'EMP_SAL_PAY_DED_TEMP.pay_amount', 'EMP_SAL_PAY_DED_TEMP.pay_type', 'DEDUCTION_TYPE.description')
                ->join('DEDUCTION_TYPE', 'EMP_SAL_PAY_DED_TEMP.type_id', '=', 'DEDUCTION_TYPE.DTYPE_ID')
                ->where('EMP_SAL_PAY_DED_TEMP.EMPLOYEE_ID', $employee_id)
                ->where('EMP_SAL_PAY_DED_TEMP.type_id', $id)
                ->where('EMP_SAL_PAY_DED_TEMP.pay_or_ded_type', $pay_or_ded_type)
                ->first();
        }




        if ($salaryPaySlips) {
            return response()->json([
                'status' => 200,
                'salaryPaySlips' => $salaryPaySlips,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Information Found.'
            ]);
        }
    }


    public function updatePhead(Request $request, $employee_id,$pay_or_ded_type, $id)
    {
        $validator = Validator::make($request->all(), [
            'status1' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }
        $data = array(
            'PAY_TYPE' => $request->status1,
            'pay_amount' => $request->amount,
        );


        SalaryPayDedTemp::where('EMPLOYEE_ID', $employee_id)->where('type_id', $id)->where('PAY_OR_DED_TYPE', $pay_or_ded_type)->update($data);

        return response()->json([
            'status' => 200,
            'message' => 'Payment Head Updated Successfully.'
        ]);

    }

}
