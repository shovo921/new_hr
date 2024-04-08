<?php

namespace App\Modules\Payroll\Http\Controllers;

use App\Functions\BranchFunction;
use App\Functions\EmployeeFunction;
use App\Http\Controllers\Controller;
use App\Modules\EmployeeIncrement\Models\SalaryDedSlip;
use App\Modules\Payroll\Models\DeductionType;
use App\Modules\Payroll\Models\Loan;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class AccountLoanController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
        $_SESSION['SubMenuActive'] = 'payroll-loan';
    }

    public function allFunctions()
    {
        $data['allEmployees'] = EmployeeFunction::allEmployees();
        $data['allBranches'] = BranchFunction::allBranches();
        $data['activeBranches'] = BranchFunction::activeOrInactiveBranches(1);
        $data['inactiveBranches'] = BranchFunction::activeOrInactiveBranches(2);
        $data['branch'] = BranchFunction::headOfficeOrBranch(2);
        $data['exe_car_loan'] = [
            '' => '-- Please Select --',
            '1' => 'No',
            '2' => 'Yes',
            '3' => 'Executive But No'
        ];
        return $data;
    }


    /**
     * Display the module welcome screen
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        // $_SESSION["SubMenuActive"] = "payroll-salary-account";

        $allFunctions = $this->allFunctions();
        $employeeList = $this->makeDD($allFunctions['allEmployees']);


        $loan = Loan::get();

        return view('Payroll::AccountLoan/view', compact('loan', 'employeeList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $allFunctions = $this->allFunctions();
        $data['exe_car_loan'] = $allFunctions['exe_car_loan'];
        $employeeList = $allFunctions['allEmployees'];
        $branchList = $this->makeDD($allFunctions['branch']);
        $dedList = $this->makeDD(DeductionType::where('status', 'L')->orderBy('dtype_id')->pluck('description', 'dtype_id'));


        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive'
        );

        return view('Payroll::AccountLoan/create', compact('employeeList', 'status', 'data', 'branchList', 'dedList'));
    }

    public function validationCheck($inputs, $createOrUpdate)
    {
        //dd($inputs['dtype_id']);
        if ($inputs['dtype_id'] != 13) {
            $acUnique = empty($createOrUpdate) ? '|unique:employee_loan,acc_no,' . $inputs['acc_no'] : '';
        } else {
            $acUnique = '';
        }

        return \Validator::make($inputs, array(
            'employee_id' => 'required',
            'branch_id' => 'required',
            'acc_no' => 'required|min:13|max:13' . $acUnique,
            'disb_amt' => 'required|numeric|between:0,99999999999999.99',
            'rate' => 'required|numeric|between:0,99999999999999.99',
            'status' => 'required|int'
        ));

    }

    public function loanAddUpdateData($request): array
    {
        return [
            'employee_id' => $request['employee_id'],
            'branch_id' => (int)$request['branch_id'],

            'acc_no' => $request['acc_no'],
            'disb_amt' => (float)($request['disb_amt']),
            'rate' => (float)($request['rate']),
            'disb_date' => date('Y-m-d', strtotime($request['disb_date'])),
            'start_month' => $request['start_month'],
            'end_month' => $request['end_month'],
            'tenor' => $request['tenor'],
            'dtype_id' => $request['dtype_id'],
            'exe_car_loan' => empty((int)$request['exe_car_loan']) ? 1 : (int)$request['exe_car_loan'],

            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'updated_at' => carbon::now(),
            'status' => (int)$request['status']
        ];


    }

    public function addOrUpdateSalDeductionData($request): array
    {
        return [
            'emp_id' => $request['employee_id'],
            'principal' => (float)($request['disb_amt']),
            'rate' => (float)($request['rate']),
            'dtype_id' => $request['dtype_id'],
            'status' => 'Y',
            'status1' => 'A',
        ];
    }

    public function addOrUpdateSalDeduction($request)
    {
        
        if($request['status'] == 1){
        $salDeductionSlip = new SalaryDedSlip();
        $duplicateCheck = $salDeductionSlip->where('emp_id', $request['employee_id'])
            ->where('dtype_id', $request['dtype_id'])->first();
        if (empty($duplicateCheck)) {
            $salDeductionSlip->fill($this->addOrUpdateSalDeductionData($request))->save();
        } else {

            $salDeductionSlip->where('emp_id', $request['employee_id'])
                ->where('dtype_id', $request['dtype_id'])
                ->update($this->addOrUpdateSalDeductionData($request));
        }
    }else{
        return Redirect()->route('loan.index')->with('msg-success', 'Loan Successfully Updated');
    }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws MassAssignmentException
     */
    public function store(Request $request)
    {
        try {
            $inputs = $request->all();

            $validator = $this->validationCheck($inputs, '');
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $salaryAccount = new Loan();
            $salaryAccount->fill($this->loanAddUpdateData($inputs))->save();
            $this->addOrUpdateSalDeduction($inputs);


            return Redirect()->route('loan.index')->with('msg-success', 'Loan Successfully Created');
        } catch (\Exception $e) {
            \Log::info('AccountLoanController-Store-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $allFunctions = $this->allFunctions();
        $data['exe_car_loan'] = $allFunctions['exe_car_loan'];

        $loanAcc = Loan::findOrFail($id);

        $employeeList = $allFunctions['allEmployees'];
        $branchList = $this->makeDD($allFunctions['branch']);
        $dedList = $this->makeDD(DeductionType::where('status', 'L')->orderBy('dtype_id')->pluck('description', 'dtype_id'));
        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive'
        );


        return view('Payroll::AccountLoan/edit', compact('loanAcc', 'status', 'data', 'employeeList', 'branchList', 'dedList'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $inputs = $request->all();

            $validator = $this->validationCheck($inputs, 1);
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }

            $salaryAccount = Loan::findOrFail($id);
            $salaryAccount->fill($this->loanAddUpdateData($inputs))->save();
            $this->addOrUpdateSalDeduction($inputs);

            return Redirect()->route('loan.index')->with('msg-success', 'Loan Successfully Updated');
        } catch (\Exception $e) {
            \Log::info('AccountLoanController-update-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        /*        try {
                    Division::destroy($id);
                    return Redirect() -> route('division.index') -> with('msg-success', 'Successfully Deleted.');
                }
                catch (\Exception $e) {
                    return Redirect() -> route('division.index') -> with('msg-error', "This item is already used.");
                }*/
    }
}
