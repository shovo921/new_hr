<?php

namespace App\Modules\JobDescription\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\JobDescription\Models\EmployeeJD;
use App\Modules\Employee\Models\EmployeeDetails;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;


class JobDescriptionController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "employee";
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $_SESSION['SubMenuActive'] = 'job-description';

        $employeeJd = (auth()->user()->employee_id == 'hradmin' ? EmployeeJD::where('approver_id','hradmin')->where('status',2)->get() :
            EmployeeJD::where('approver_id', auth()->user()->employee_id)->get());

        return view('JobDescription::JD/view', compact('employeeJd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeeList = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->whereRaw('employee_id NOT IN(select EMPLOYEE_ID from EMPLOYEE_SALARY_ACCOUNT where STATUS=1)')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');


        $branchList = $this->makeDD(Branch::where('head_office', 2)->orderBy('branch_name')->pluck('branch_name', 'id'));
//        dd($branchList);

        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive'
        );

        return view('Payroll::SalaryAccount/create', compact('employeeList', 'status', 'branchList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();


        $validator = \Validator::make($inputs, array(
            'employee_id' => 'required',
            'branch_id' => 'required',
            'account_no' => 'required',
            'status' => 'required|int'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        $status = SalaryAccount::select('status')
            ->where('employee_id', $request->employee_id)
            ->first();

        if (!empty($status)) {
            if ($status->status == 1) {
                return Redirect()->back()->with('msg-error', 'SalaryAccount Already Exists');

            } else {
                $salaryAccount = new SalaryAccount();

                $data = array(
                    'employee_id' => $request->employee_id,
                    'status' => (int)$request->status,
                    'branch_id' => (int)$request->branch_id,
                    'account_no' => $request->account_no,
                    'created_by' => 1
                );
                $salaryAccount->fill($data)->save();

                return Redirect()->back()->with('msg-success', 'SalaryAccount Successfully Created');

            }

        } else {

            $data = array(
                'employee_id' => $request->employee_id,
                'branch_id' => (int)$request->branch_id,
                'account_no' => $request->account_no,
                'created_by' => 1,
                'status' => (int)$request->status
            );

//            dd($data);

            $salaryAccount = new SalaryAccount();
            $salaryAccount->fill($data)->save();

            return Redirect()->back()->with('msg-success', 'SalaryAccount Successfully Created');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $employeeList = $this->makeDD($employeeData);

//        $salaryAccount = SalaryAccount::get();
        $salaryAccount = $this->__allSalaryAccountFilter($request);


        return view('Payroll::SalaryAccount/view', compact('salaryAccount', 'employeeList'));
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
     * This function is responsible to check the Division Head or Branch Head Employee ID
     *
     * @return \Illuminate\Http\Response
     */
    public function getHeadOfDivOrBranchEmpId($branchId)
    {
        $divisionHead = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->join('employee_posting', 'employee_details.employee_id', '=', 'employee_posting.employee_id')
            ->join('br_div_head', 'br_div_head.posting_id', '=', 'employee_posting.id')
            ->where('br_div_head.branch_id', $branchId)
            ->where('br_div_head.status', '=', 1)->first();
        return $divisionHead;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($employee_id)
    {
        $employeeDetails = EmployeeDetails::where('employee_id', $employee_id)->first();

        $head = $this->getHeadOfDivOrBranchEmpId($employeeDetails->branch_id);
        $branchHead = substr($head->employee_name, 0, 11);

        /**
         * Inline If else condition
         */
        $headOfDivOrBranchEmpId = (($branchHead == $employee_id) ? 'hradmin' : $head);

        /**
         * if else condition
         */
        /* if ($head->employee_id == $employee_id) {
             $headOfDivOrBranchEmpId = $head->employee_id;
         } else {
             $headOfDivOrBranchEmpId = 'hradmin';
         }*/


        $employeeJd = EmployeeJD::where('employee_id', $employee_id)->first();

        return view('JobDescription::JD/edit', compact('employeeDetails', 'headOfDivOrBranchEmpId', 'headOfDivOrBranchEmpId', 'employeeJd'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param $status
     * @param $remarks
     * @param int $id
     * @param $branch_head
     * @param $signed_at
     * @param $approved_at
     * @return string
     */
    public function updateJd($status, $remarks, $id, $branch_head, $signed_at, $approved_at)
    {
        $data = array(
            'status' => (int)$status,
            'remarks' => $remarks,
            'approver_id' => $branch_head,
            'signed_at' => $signed_at,
            'approved_at' => $approved_at
        );
        EmployeeJD::findOrFail($id)->update($data);
        return 'success';

    }

    /**
     * This function is used for verifying the JD
     * @param Request $request
     * @param $id
     * @return RedirectResponse|void
     */
    public function checkAndApproveJd(Request $request, $id)
    {
        switch ($request->submit) {
            case  'Checked':
                $branchHead = substr($request->branch_head, 0, 11);
                $signedAt = carbon::now();
                $this->updateJd($request->status, null, $id, $branchHead, $signedAt, null);
                return Redirect()->to('home')->with('msg-success', 'Successfully Agreed with Job Description');
                break;
            case 'Approved' :
                $approvedAt = carbon::now();
                $branchHead = substr($request->branch_head, 0, 11);
                $signedAt = EmployeeJD::select('signed_at')->where('id', $id)->first();
                $this->updateJd(3, $request->remarks, $id, $branchHead, $signedAt->signed_at, $approvedAt);
                return Redirect()->to('home')->with('msg-success', 'Job Description Successfully Approved');
                break;
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
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
