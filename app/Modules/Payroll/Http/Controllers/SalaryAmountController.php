<?php

namespace App\Modules\Payroll\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\EmployeeSalary;
use App\Modules\EmployeeIncrement\Models\SalaryDedSlip;
use App\Modules\EmployeeIncrement\Models\SalaryPaySlip;
use App\Modules\Payroll\Models\DeductionType;
use App\Modules\Payroll\Models\PayType;
use App\Modules\Payroll\Models\SalaryAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;


class SalaryAmountController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    /**
     * Display the module welcome screen
     *
     * @param int $employee_id
     *
     * @return \Illuminate\Http\Response
     */
    public function index($employee_id)
    {

        $salaryPaySlips = SalaryPaySlip::where('emp_id', $employee_id)->get();
        $payHeadLists = PayType::where('status', "A")->get();
        return view('Payroll::SalaryAmount/edit-pay-head-modal', compact('salaryPaySlips', 'employee_id', 'payHeadLists'));


    }

    /**
     * Display the module welcome screen
     *
     * @param int $employee_id
     *
     * @return \Illuminate\Http\Response
     */

    public function fetchInfo($employee_id)
    {
        $salaryPaySlips = SalaryPaySlip::select('SALARYPAY_SLIP.emp_id', 'SALARYPAY_SLIP.ptype_id', 'SALARYPAY_SLIP.amount', 'SALARYPAY_SLIP.status1', 'PAY_TYPE.description')
            ->join('PAY_TYPE', 'SALARYPAY_SLIP.ptype_id', '=', 'PAY_TYPE.ptype_id')
            ->where('SALARYPAY_SLIP.emp_id', $employee_id)
            ->get();

        return response()->json([
            'salaryPaySlips' => $salaryPaySlips,
        ]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $empSal = new EmployeeSalary();


        if ($request->type_id == 1) {
            $paymentDuplicateCheckSlip = SalaryPaySlip::where('emp_id', $request->emp_id)->where('ptype_id', $request->ptype_id)->first();
            $validator = Validator::make($request->all(), [
                'status' => 'required',
                'status1' => 'required',
                'rate' => 'required',
                'ptype_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            }
            $paySlip = new SalaryPaySlip();
            $data = array(
                'emp_id' => $request->emp_id,
                'status' => $request->status,
                'status1' => $request->status1,
                'amount' => (float)$request->rate,
                'ptype_id' => (int)$request->ptype_id,
            );

            if ($request->ptype_id == 81) {
                $empSal->where('employee_id', $request->emp_id)->update(
                    ['technical_allowance' => $request->rate]
                );
                if (empty($paymentDuplicateCheckSlip)) {
                    $paySlip->fill($data)->save();
                } else {
                    $paySlip->where('emp_id', $paymentDuplicateCheckSlip->emp_id)
                        ->where('ptype_id', $paymentDuplicateCheckSlip->ptype_id)
                        ->update($data);
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Payment  Head Added Successfully.'
                ]);
            } else {
                $duplicateCheckSlip = SalaryDedSlip::where('emp_id', $request->emp_id)->where('dtype_id', $request->dtype_id)->first();
                $validator = Validator::make($request->all(), [
                    'status' => 'required',
                    'status1' => 'required',
                    'rate' => 'required',
                    'dtype_id' => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'errors' => $validator->messages()
                    ]);
                }

                $dedSlip = new SalaryDedSlip();


                $data = array(
                    'emp_id' => $request->emp_id,
                    'status' => $request->status,
                    'status1' => $request->status1,
                    'rate' => (float)$request->rate,
                    'principal' => number_format(0, 2),
                    'dtype_id' => (int)$request->dtype_id,
                );

                if ($request->dtype_id == 4) {
                    $empSal->where('employee_id', $request->emp_id)->update(
                        ['income_tax' => $request->rate]
                    );
                } else if ($request->dtype_id == 7) {
                    $empSal->where('employee_id', $request->emp_id)->update(
                        ['welfare_fund' => $request->rate]
                    );
                } else if ($request->dtype_id == 2) {
                    $empSal->where('employee_id', $request->emp_id)->update(
                        ['hb_loan_installment' => $request->rate]
                    );
                } else if ($request->dtype_id == 3) {
                    $empSal->where('employee_id', $request->emp_id)->update(
                        ['car_loan_installment' => $request->rate]
                    );
                } else if ($request->dtype_id == 19) {
                    $empSal->where('employee_id', $request->emp_id)->update(
                        ['personal_loan_installment' => $request->rate]
                    );
                } else if ($request->dtype_id == 13) {
                    $empSal->where('employee_id', $request->emp_id)->update(
                        ['pf_loan_installment' => $request->rate]
                    );
                }

                if (empty($duplicateCheckSlip)) {
                    $dedSlip->fill($data)->save();
                } else {
                    $dedSlip->where('emp_id', $duplicateCheckSlip->emp_id)
                        ->where('dtype_id', $duplicateCheckSlip->dtype_id)
                        ->update($data);
                }


                return response()->json([
                    'status' => 200,
                    'message' => 'Deduction Head Added Successfully.'
                ]);

            }
        }
        else {
            $duplicateCheckSlip = SalaryDedSlip::where('emp_id', $request->emp_id)->where('dtype_id', $request->dtype_id)->first();
            $validator = Validator::make($request->all(), [
                'status' => 'required',
                'status1' => 'required',
                'rate' => 'required',
                'dtype_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->messages()
                ]);
            }

            $dedSlip = new SalaryDedSlip();
            $empSal = new EmployeeSalary();

            $data = array(
                'emp_id' => $request->emp_id,
                'status' => $request->status,
                'status1' => $request->status1,
                'rate' => (float)$request->rate,
                'principal' => number_format(0, 2),
                'dtype_id' => (int)$request->dtype_id,
            );

            if ($request->dtype_id == 4) {
                $empSal->where('employee_id', $request->emp_id)->update(
                    ['income_tax' => $request->rate]
                );
            } else if ($request->dtype_id == 7) {
                $empSal->where('employee_id', $request->emp_id)->update(
                    ['welfare_fund' => $request->rate]
                );
            } else if ($request->dtype_id == 2) {
                $empSal->where('employee_id', $request->emp_id)->update(
                    ['hb_loan_installment' => $request->rate]
                );
            } else if ($request->dtype_id == 3) {
                $empSal->where('employee_id', $request->emp_id)->update(
                    ['car_loan_installment' => $request->rate]
                );
            } else if ($request->dtype_id == 19) {
                $empSal->where('employee_id', $request->emp_id)->update(
                    ['personal_loan_installment' => $request->rate]
                );
            } else if ($request->dtype_id == 13) {
                $empSal->where('employee_id', $request->emp_id)->update(
                    ['pf_loan_installment' => $request->rate]
                );
            }

            if (empty($duplicateCheckSlip)) {
                $dedSlip->fill($data)->save();
            } else {
                $dedSlip->where('emp_id', $duplicateCheckSlip->emp_id)
                    ->where('dtype_id', $duplicateCheckSlip->dtype_id)
                    ->update($data);
            }


            return response()->json([
                'status' => 200,
                'message' => 'Deduction Head Added Successfully.'
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $employee_id
     * @return \Illuminate\Http\Response
     */
    public function show($employee_id)
    {
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
        foreach ($salaryPaySlips as $salaryPaySlip) {
            $payTotal += (float)$salaryPaySlip->amount;
        }


        foreach ($salaryDedSlips as $salaryDedSlip) {
            $dedTotal += (float)$salaryDedSlip->rate;
        }

//        dd($payHeadTypeDatas,$dedTypeDatas);
        return view('Payroll::SalaryAmount/view', compact('employeeSalary', 'salaryPaySlips', 'salaryDedSlips', 'payTotal', 'dedTotal', 'payHeadLists', 'dedTypeDatas', 'payHeadTypeDatas'));
    }

    /**
     * Display the module welcome screen
     *
     * @return Response
     */

    private function __allSalaryAccountFilter($request)
    {
        $salaryAccount = SalaryAccount::query();

        if ($request->filled('employee_id')) {
            $salaryAccount->where('employee_id', $request->employee_id);
        }
        return $salaryAccount->paginate(10);
    }

    /**
     *
     * This function is for editing payment Head
     *
     * @param int $employee_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */


    public function editPayHead($employee_id)
    {

        $payHeadData = PayType::select(DB::raw("(description) description"), 'ptype_id')
            ->where('status', "A")
            ->pluck('description', 'ptype_id');

        $payHeadLists = $this->makeDD($payHeadData);

        $salaryPaySlips = SalaryPaySlip::where('emp_id', $employee_id)->get();


        return view('Payroll::SalaryAmount/edit-pay-head-modal', compact('salaryPaySlips', 'payHeadLists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($employee_id)
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

        return view('Payroll::SalaryAmount/edit', compact('employeeSalary', 'salaryPaySlips', 'salaryDedSlips', 'payTotal', 'dedTotal'));
    }

    /**
     * This function is for editing Payment Head Status
     *
     * @param int $id
     * * @param int $employee_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editPhead($employee_id, $id)
    {
        $salaryPaySlips = SalaryPaySlip::select('SALARYPAY_SLIP.emp_id', 'SALARYPAY_SLIP.ptype_id', 'SALARYPAY_SLIP.amount', 'SALARYPAY_SLIP.status1', 'PAY_TYPE.description')
            ->join('PAY_TYPE', 'SALARYPAY_SLIP.ptype_id', '=', 'PAY_TYPE.ptype_id')
            ->where('SALARYPAY_SLIP.emp_id', $employee_id)
            ->where('SALARYPAY_SLIP.ptype_id', $id)
            ->first();

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

    /**
     * This function is for updating Payment Head Status
     *
     * @param int $id
     * @param int $employee_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePhead(Request $request, $employee_id, $id)
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
            'status1' => $request->status1,
            'amount' => $request->amount,
        );

        SalaryPaySlip::where('emp_id', $employee_id)->where('ptype_id', $id)->update($data);

        return response()->json([
            'status' => 200,
            'message' => 'Payment Head Updated Successfully.'
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $salaryAccount = SalaryAccount::findOrFail($id);
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array(
            'employee_id' => 'required',
            'branch_id' => 'required',
            'account_no' => 'required',
            'status' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array(
            'employee_id' => $request->employee_id,
            'branch_id' => (int)$request->branch_id,
            'account_no' => $request->account_no,
            'updated_by' => auth()->user()->id,
            'updated_at' => Carbon::now(),
            'status' => (int)$request->status
        );

        SalaryAccount::findOrFail($id)->update($data);

        return Redirect()->back()->with('msg-success', 'Employee SalaryAccount Successfully Updated');
    }


}
