<?php
/**
 * Purpose: This Controller Used for Employee Transfer Posting Information Manage
 * Created: Jobayer Ahmed
 * Change history:
 * 08/02/2021 - Jobayer
 **/

namespace App\Modules\Employee\Http\Controllers;

use App\Functions\AttendanceFunction;
use App\Functions\BranchFunction;
use App\Functions\EmployeeFunction;
use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\BrDepartment\Models\BrDepartment;
use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\DepartmentUnit\Models\DepartmentUnit;
use App\Modules\Designation\Models\Designation;
use App\Modules\Employee\Models\BrDivHead;
use App\Modules\Employee\Models\ClusterHead;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeePosting;
use App\Modules\Employee\Models\EmployeePostingHistory;
use App\Modules\Employee\Models\EmployeeVAllInfo;
use App\Modules\Employee\Models\EmpTransferTransit;
use App\Modules\Employee\Models\EmpTransferTransitLog;
use App\Modules\FunctionalDesignation\Models\FunctionalDesignation;
use App\Modules\JobStatus\Models\JobStatus;
use App\Modules\TransferType\Models\TransferType;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use function Symfony\Component\Translation\t;


class EmployeePostingController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "transfer";
    }

    /**
     * Employee Posting Information List Search
     * @param Request $request
     * @return Application|Factory|View
     */
    public function empPostingInfo(Request $request)
    {
        $allEmployeePosting = $this->__allEmpPostingFilter($request);

        /**
         * Calling Functions
         */
        $employeeFunction = new EmployeeFunction();
        $branchFunction = new BranchFunction();
        $attendanceFunction = new AttendanceFunction();

        $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $branchList = $this->makeDD(Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')->pluck('branch_name', 'branch'));
        $designationList = $this->makeDD(Designation::select(DB::raw("(designation) designation_name"), 'id as designation_id')->orderby('seniority_order')->pluck('designation_name', 'designation_id'));

        return view("Employee::emp_posting_list", compact('allEmployeePosting', 'allEmployees', 'branchList', 'designationList'));
    }

    /**
     * Employee Posting Information List Search Filter
     * @param $request
     * @return mixed
     */
    private function __allEmpPostingFilter($request)
    {

        $allEmployeePosting = EmployeePosting::select('employee_posting.*')
            ->join('employee_details as ed', 'employee_posting.employee_id', '=', 'ed.employee_id')
            ->where('ed.status', '=', '1');

        if ($request->filled('employee_id')) {
            $allEmployeePosting->where('employee_posting.employee_id', $request->employee_id);
        }

        if ($request->filled('branch')) {
            $allEmployeePosting->where('employee_posting.branch_id', $request->branch);
        }

        if ($request->filled('designation_id')) {
            $allEmployeePosting->where('ed.designation_id', $request->designation_id);
        }

        return $allEmployeePosting->orderBy(DB::RAW('EMP_SENIORITY_ORDER(ed.employee_id)'))->paginate(10);
    }


    /**
     * Branch or Division Head List Search option
     * @param Request $request
     * @return Application|Factory|View
     */
    public function brDivHeadInfo(Request $request)
    {

        $brDivHeadList = $this->__brDivHeadFilter($request);

        $allEmployees = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->join('employee_posting as ep', 'ep.employee_id', '=', 'employee_details.employee_id')
            ->join('br_div_head as bh', 'ep.id', '=', 'bh.posting_id')
            ->where('employee_details.status', 1)
            ->pluck('employee_details.employee_name', 'employee_details.employee_id');

        $branchList = $this->makeDD(Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')->pluck('branch_name', 'branch'));
        $designationList = $this->makeDD(Designation::select(DB::raw("(designation) designation_name"), 'id as designation_id')->orderby('seniority_order')->pluck('designation_name', 'designation_id'));

        return view("Employee::br_head_list", compact('brDivHeadList', 'allEmployees', 'allEmployees', 'branchList', 'designationList'));
    }

    /**
     * Branch or Division Head Filter
     * @param $request
     * @return mixed
     */
    private function __brDivHeadFilter($request)
    {

        $brDivHeadList = EmployeePosting::select('employee_posting.employee_id',
            'employee_posting.id', 'bh.branch_id', 'bh.status', 'bh.start_date as effective_date')
            ->join('employee_details as ed', 'employee_posting.employee_id', '=', 'ed.employee_id')
            ->join('br_div_head as bh', 'employee_posting.id', '=', 'bh.posting_id');


        if ($request->filled('employee_id')) {
            $brDivHeadList->where('employee_posting.employee_id', $request->employee_id);
        }

        if ($request->filled('branch')) {
            $brDivHeadList->where('bh.branch_id', $request->branch);
        }

        if ($request->filled('designation_id')) {
            $brDivHeadList->where('ed.designation_id', $request->designation_id);
        }

        return $brDivHeadList->orderBy(DB::RAW('EMP_SENIORITY_ORDER(ed.employee_id)'))->paginate(10);
    }


    /**
     * Transfer Posting From View
     * @return Application|Factory|RedirectResponse|View
     */
    public function employeeTransfer()
    {
        try {
            $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->pluck('employee_name', 'employee_id');
            $employeeList = $this->makeDD($employeeData);
            $jobStatus = $this->makeDD(JobStatus::where('STATUS', '1')->pluck('job_status', 'id'));
            $branchList = $this->makeDD(Branch::pluck('branch_name', 'id'));
            $branchDivisionList = $this->makeDD(BrDivision::pluck('br_name', 'id'));
            $branchDepartmentList = $this->makeDD(BrDepartment::pluck('dept_name', 'id'));
            $branchUnitList = $this->makeDD(DepartmentUnit::pluck('unit_name', 'id'));
            $functionalDesignations = FunctionalDesignation::where('status', 1)->pluck('designation', 'id');
            $confirmation = ['Yes' => 'Yes', 'No' => 'No'];
            $transferType = $this->makeDD(TransferType::pluck('transfer_type', 'id'));
            $allBranch = Branch::where('branch_id', 'not like', 'H%')->get();
            $branch = $this->makeDD(Branch::where('head_office',2)->pluck('branch_name', 'id'));
            return view('Employee::employee_transfer', compact('employeeList', 'jobStatus', 'branchList', 'branchDivisionList', 'branchDepartmentList', 'branchUnitList', 'functionalDesignations', 'confirmation', 'transferType', 'allBranch','branch'));

        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Employee Current Transfer View for Updating
     * @return Application|Factory|RedirectResponse|View
     */
    public function employeeCurrentTransferView($postingId)
    {
        try {
            $empPostingInfo = EmployeePosting::where('id', $postingId)->first();
            $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->where('employee_id', $empPostingInfo->employee_id)
                ->pluck('employee_name', 'employee_id');
            $employeeList = $this->makeDD($employeeData);
            $jobStatus = $this->makeDD(JobStatus::where('STATUS', '1')->pluck('job_status', 'id'));
            $branchList = $this->makeDD(Branch::pluck('branch_name', 'id'));
            $branchDivisionList = $this->makeDD(BrDivision::pluck('br_name', 'id'));
            $branchDepartmentList = $this->makeDD(BrDepartment::pluck('dept_name', 'id'));
            $branchUnitList = $this->makeDD(DepartmentUnit::pluck('unit_name', 'id'));
            $functionalDesignations = FunctionalDesignation::where('status', 1)->pluck('designation', 'id');
            $confirmation = ['Yes' => 'Yes', 'No' => 'No'];
            $transferType = $this->makeDD(TransferType::pluck('transfer_type', 'id'));
            $branch = $this->makeDD(Branch::where('head_office',2)->pluck('branch_name', 'id'));
            $allBranch = Branch::get();
            return view('Employee::employee_transfer_edit', compact('employeeList', 'branch','empPostingInfo', 'jobStatus', 'branchList', 'branchDivisionList', 'branchDepartmentList', 'branchUnitList', 'functionalDesignations', 'confirmation', 'transferType', 'allBranch'));
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Current Transfer Posting Edit
     * @param Request $request
     * @param $postingId
     * @return RedirectResponse
     */
    public function employeeCurrentTransferEdit(Request $request, $postingId)
    {
        try {
            $inputs = $request->all();
            $tansInfo['employee_id'] = $inputs['employee_id'];
            $tansInfo['job_status_id'] = $inputs['job_status_id'];
            $tansInfo['branch_id'] = $inputs['branch_id'];
            $tansInfo['br_division_id'] = $inputs['br_division_id'];
            $tansInfo['br_department_id'] = $inputs['br_department_id'];
            $tansInfo['br_unit_id'] = $inputs['br_unit_id'];
            $tansInfo['functional_designation'] = $inputs['functional_designation'];
            $tansInfo['accommodation'] = $inputs['accommodation'];
            $tansInfo['reporting_officer'] = $inputs['reporting_officer'];
            $tansInfo['transfer_type_id'] = $inputs['transfer_type_id'];
            $EFFECTIVE_DATE = str_replace('/', '-', $inputs['effective_date']);
            $tansInfo['effective_date'] = date("d-m-Y", strtotime($EFFECTIVE_DATE));
            $tansInfo['handover_status'] = $inputs['handover_status'];
            $tansInfo['ipal_flag'] = json_encode($inputs['ipal_flag']);
            $tansInfo['posting_status'] = 1;
            $tansInfo['br_head'] = empty($inputs['br_head']) ? 2 : $inputs['br_head'];
            $tansInfo['cluster_head'] = empty($inputs['cluster_head']) ? 2 : $inputs['cluster_head'];
            $tansInfo['dept_head'] = empty($inputs['dept_head']) ? 2 : $inputs['dept_head'];
            $tansInfo['last_updated_date'] = Carbon::now();
            $tansInfo['transfer_reference'] = $inputs['transfer_reference'];
            $tansInfo['working_at'] = $inputs['working_at'];


            $userBranchUpdate['branch_id'] = $inputs['branch_id'];
            $branch_name = Branch::where('id', $inputs['branch_id'])->first();
            $userBranchUpdate['branch_name'] = $branch_name->branch_name;

            EmployeePosting::where('id', $postingId)->update($tansInfo);
            User::where('employee_id', $inputs['employee_id'])->update($userBranchUpdate);
            EmployeeDetails::where('employee_id', $inputs['employee_id'])->update($userBranchUpdate);

            return redirect()->back()->with('msg-success', 'Employee Transfer/Posting Successfully Updated');;
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }


    /**
     * Transfer Posting Store to DB
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeEmployeeTransfer(Request $request)
    {
        $inputs = $request->all();

        $employee_id = $request->employee_id;
        $employeeInfo = EmployeeDetails::where('employee_id', $employee_id)->first();
        $empPosting = EmployeePosting::where('employee_id', $employee_id)->first();
        $transferTransit = EmpTransferTransit::where('posting_id', $empPosting->id)->where('status', 1);
        $lastPostingInfo = EmployeePostingHistory::where('employee_id', $employee_id)->where('posting_status', '2');

        $tansInfo['employee_id'] = $inputs['employee_id'];
        $tansInfo['job_status_id'] = $inputs['job_status_id'];
        $tansInfo['branch_id'] = $inputs['branch_id'];
        $tansInfo['br_division_id'] = $inputs['br_division_id'];
        $tansInfo['br_department_id'] = $inputs['br_department_id'];
        $tansInfo['br_unit_id'] = $inputs['br_unit_id'];
        $tansInfo['functional_designation'] = $inputs['functional_designation'];
        $tansInfo['accommodation'] = $inputs['accommodation'];
        $tansInfo['reporting_officer'] = $inputs['reporting_officer'];
        $tansInfo['transfer_type_id'] = $inputs['transfer_type_id'];
        $EFFECTIVE_DATE = str_replace('/', '-', $inputs['effective_date']);
        $tansInfo['effective_date'] = date("d-m-Y", strtotime($EFFECTIVE_DATE));
        $tansInfo['handover_status'] = $inputs['handover_status'];
        $tansInfo['cr_branch_reliever'] = $inputs['cr_branch_reliever'];
        $tansInfo['ipal_flag'] = json_encode($inputs['ipal_flag']);
        $tansInfo['posting_status'] = '2';
        $tansInfo['br_head'] = empty($inputs['br_head']) ? 2 : $inputs['br_head'];
        $tansInfo['cluster_head'] = empty($inputs['cluster_head']) ? 2 : $inputs['cluster_head'];
        $tansInfo['dept_head'] = empty($inputs['dept_head']) ? 2 : $inputs['dept_head'];
        $tansInfo['designation_id'] = $employeeInfo->designation_id;
        $tansInfo['last_created_date'] = Carbon::now();
        $tansInfo['transfer_reference'] = $inputs['transfer_reference'];
        $tansInfo['is_current'] = 1;
        $tansInfo['working_at'] = $inputs['working_at'];


        $brDivHead = BrDivHead::where('branch_id', $inputs['branch_id'])->where('status', 2)->first();

        $clusterHead = ClusterHead::select('cluster_info.*')
            ->join('branch', 'branch.cluster_id', '=', 'cluster_info.id')
            ->where('branch.id', $inputs['branch_id'])
            ->first();


        if ($lastPostingInfo->count() > '0') {
            return redirect()->back()->with('msg-error', 'Employee Transfer/Posting Already Exists and Waiting for Authorization');
        } else {
            if ($tansInfo['br_head'] == 1 || $tansInfo['cluster_head'] == 1) {
                if (!empty($clusterHead->status)) {
                    if ($tansInfo['cluster_head'] == 1) {
                        if ($brDivHead->status == 1 || $clusterHead->status == 1) {
                            return redirect()->back()->with('msg-error', 'This Branch Already Branch/Cluster Head');
                        } else {
                            EmployeePostingHistory::create($tansInfo);
                            //EmpTransferTransit::create($this->empTransferTransitEntryArray($empPosting->id, $request));
                            return redirect()->back()->with('msg-success', 'Employee Transfer/Posting Successfully Added and Send for Authorization');
                        }
                    } else {
                        EmployeePostingHistory::create($tansInfo);
                        //EmpTransferTransit::create($this->empTransferTransitEntryArray($empPosting->id, $request));
                        return redirect()->back()->with('msg-success', 'Employee Transfer/Posting Successfully Added and Send for Authorization');
                    }

                } else {
                    if (!empty($brDivHead->status)) {
                        if ($brDivHead->status == 1) {
                            return redirect()->back()->with('msg-error', 'This Branch Already Branch/Cluster Head');
                        } else {
                            EmployeePostingHistory::create($tansInfo);
                            //EmpTransferTransit::create($this->empTransferTransitEntryArray($empPosting->id, $request));
                            return redirect()->back()->with('msg-success', 'Employee Transfer/Posting Successfully Added and Send for Authorization');
                        }
                    } else {
                        EmployeePostingHistory::create($tansInfo);
                        // EmpTransferTransit::create($this->empTransferTransitEntryArray($empPosting->id, $request));
                        return redirect()->back()->with('msg-success', 'Employee Transfer/Posting Successfully Added and Send for Authorization');
                    }

                }
            } else {
                EmployeePostingHistory::create($tansInfo);
                // EmpTransferTransit::create($this->empTransferTransitEntryArray($empPosting->id, $request));
                return redirect()->back()->with('msg-success', 'Employee Transfer/Posting Successfully Added and Send for Authorization');
            }

        }
    }


    public function empTransferTransitEntryArray($posting_id, $request): array
    {
        //1=Initial(waiting for 1st reliever),
        //2=Processing(waiting for 2nd reliever),
        //3=(waiting for HR Authorization),
        //4=HR Approve,5=Cancel

        /**
         * Transfer Order File Save
         */

        $path = public_path('uploads/employeedata/' . $request->employee_id . '/transferfile');
        $fileName = 'transfer_order_' . $posting_id . '.' . $request->t_order_file->extension();
        $request->t_order_file->move($path, $fileName);

        return [
            'posting_id' => $posting_id,
            'cr_branch_reliever' => $request->cr_branch_reliever,
            'posted_reporting_officer' => $request->reporting_officer,
            't_order_file' => $fileName,
            'cr_responsible' => $request->cr_branch_reliever,
            'created_by' => auth()->user()->id,
            'status' => 1
        ];


    }

    public function transferTransitAction(Request $request)
    {


        $transitInfo = EmpTransferTransit::where('id', $request->id)->first();
        $path = public_path('uploads/employeedata/' . $transitInfo->employee->employee_id . '/transferfile');
        if (auth()->user()->employee_id == $transitInfo->cr_responsible) {

            try {
                if ($transitInfo->cr_branch_reliever == $transitInfo->cr_responsible) {
                    $fileName = 'handOrTakeOver_File_' . $request->posting_id . '.' . $request->handortakeover_file->extension();
                    $request->handortakeover_file->move($path, $fileName);
                    $data = [
                        'handortakeover_file' => $fileName,
                        'cr_responsible' => $transitInfo->posted_reporting_officer,
                        'updated_by' => auth()->user()->id,
                        'updated_at' => Carbon::now(),
                        'remarks' => $request->remarks,
                        'status' => 2
                    ];
                    $this->transitLogSave($request, $transitInfo->cr_branch_reliever);
                } else {
                    $fileName = 'joining_letter_' . $request->posting_id . '.' . $request->joining_letter->extension();
                    $request->joining_letter->move($path, $fileName);
                    $data = [
                        'joining_letter' => $fileName,
                        'updated_by' => auth()->user()->id,
                        'updated_at' => Carbon::now(),
                        'remarks' => $request->remarks,
                        'cr_responsible' => 'hradmin',
                        'status' => 3
                    ];
                    $this->transitLogSave($request, $transitInfo->posted_reporting_officer);
                }
                $transitInfo->update($data);


                return redirect()->back()->with('msg-success', 'Employee Transfer/Posting Successfully Added and Send for Authorization');
            } catch (\Exception $e) {
                return redirect()->back()->with('msg-error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('msg-error', 'Unauthorized User Please contact to HR');
        }


    }

    public function transferTransitUpdate(Request $request)
    {
        $transitInfo = EmpTransferTransit::findOrFail($request->id);
        if ($transitInfo->status == 1) {
            $data = [
                'cr_branch_reliever' => $request->cr_branch_reliever,
                'cr_responsible' => $request->cr_branch_reliever,
            ];

        } else if ($transitInfo->status == 2) {
            $data = [
                'posted_reporting_officer' => $request->posted_reporting_officer,
                'cr_responsible' => $request->posted_reporting_officer,
            ];
        }

        $transitInfo->update($data);
        return redirect()->back()->with('msg-success', 'Employee Transit information Updated');
    }

    public function transitLogSave($request, $cr_responsible)
    {

        try {
            $transitLog = new EmpTransferTransitLog();
            $transitInfo = EmpTransferTransit::where('id', $request->id)->first();
            $data = [
                'transit_id' => $request->id,
                'posting_id' => $transitInfo->posting_id,
                'reliever' => $cr_responsible,
                'remarks' => $request->remarks,
                'updated_at' => Carbon::now()
            ];

            $transitLog->create($data);
            return redirect()->back()->with('msg-success', 'Information Updated');
        } catch
        (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function transferTransit($id, $isEdit)
    {
        $data['transitInfo'] = EmpTransferTransit::findOrfail($id);
        $data['postingHistory'] = EmployeePostingHistory::where('employee_id', $data['transitInfo']->employee->employee_id)->where('posting_status', 2)->first();

        $data['currentEmpLists'] = $this->makeDD(EmployeeFunction::getEmployeesCurrentDivisionOrBranchMembers($data['postingHistory']->employee_id));
        $data['postedEmpLists'] = $this->makeDD(EmployeeFunction::branchEmployees($data['postingHistory']->branch->id));

        if ($isEdit == 'Yes') {
            return view('Employee::transit_from_edit', compact('data'));
        } else {
            return view('Employee::transit_from', compact('data'));
        }

    }

    public function transferTransitView()
    {
        $data['transitInfo'] = EmpTransferTransit::get()->chunk(100);
        return view('Employee::transfer_transit_view', compact('data'));
    }


    /**
     * @param $employeeId
     * @return false|string
     * Used For Employee Posting section
     */
    public function getCurrentEmployeesByEmployeeId(Request $request)
    {
        $data = EmployeeFunction::getEmployeesCurrentDivisionOrBranchMembers($request->employeeId);
        $option = '<option value="">--Please Select--</option>';

        foreach ($data as $key => $value) {
            $option .= '<option value=' . $key . ' >' . $value . '</option>';
        }
        return $option;
    }

    /**
     * @param $branchId
     * @return false|string
     * Used From Employee Posting
     */
    public function getCurrentBranchEmployees(Request $request)
    {
        $data = EmployeeFunction::branchEmployees($request->branchId);
        $option = '<option value="">--Please Select--</option>';

        foreach ($data as $key => $value) {
            $option .= '<option value=' . $key . ' >' . $value . '</option>';
        }
        return $option;

    }


    /**
     * Transfer Posting Employee List Authorization View
     * @return Application|Factory|RedirectResponse|View
     */
    public function postingAuthorization()
    {
        try {
            $postingInfo = array();

            $posting = EmployeePostingHistory::where('posting_status', '2');
            if ($posting->count() > 0) {
                $postingInfo = $posting->get();
            }
            return view('Employee::posting_auth', compact('postingInfo'));
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Transfer Posting Authorization Controller
     * @param $employee_id
     * @return RedirectResponse
     */
    public function authorizedPosting($employee_id)
    {
        try {
            \DB::beginTransaction();

            $lastIncrementInfo = EmployeePostingHistory::where('employee_id', $employee_id)
                ->where('posting_status', '2')
                ->orderby(DB::raw("TO_DATE(EFFECTIVE_DATE, 'DD-MM-YYYY')"), 'DESC')
                ->first();

            $immediateLastPosting = EmployeePostingHistory::where('employee_id', $employee_id)
                ->where('posting_status', '1')
                ->orderby(DB::raw("TO_DATE(EFFECTIVE_DATE, 'DD-MM-YYYY')"), 'DESC')
                ->first();


            $employeePosting = EmployeePosting::where('employee_id', $employee_id)->first();

            $postingInfo['employee_id'] = $employee_id;
            $postingInfo['job_status_id'] = intval($lastIncrementInfo->job_status_id);
            $postingInfo['branch_id'] = $lastIncrementInfo->branch_id;
            $postingInfo['br_division_id'] = $lastIncrementInfo->br_division_id;
            $postingInfo['br_department_id'] = $lastIncrementInfo->br_department_id;
            $postingInfo['br_unit_id'] = $lastIncrementInfo->br_unit_id;
            $postingInfo['functional_designation'] = $lastIncrementInfo->functional_designation;
            $postingInfo['accommodation'] = $lastIncrementInfo->accommodation;
            $postingInfo['reporting_officer'] = $lastIncrementInfo->reporting_officer;
            $postingInfo['transfer_type_id'] = $lastIncrementInfo->transfer_type_id;
            $postingInfo['effective_date'] = $lastIncrementInfo->effective_date;
            $postingInfo['handover_status'] = $lastIncrementInfo->handover_status;
            $postingInfo['ipal_flag'] = $lastIncrementInfo->ipal_flag;
            $postingInfo['posting_status'] = '1';
            $postingInfo['last_updated_date'] = Carbon::now();
            $postingInfo['approved_by'] = auth()->user()->id;
            $postingInfo['approved_date'] = Carbon::now();
            $postingInfo['transfer_reference'] = $lastIncrementInfo->transfer_reference;
            $postingInfo['br_head'] = $lastIncrementInfo->br_head;
            $postingInfo['dept_head'] = $lastIncrementInfo->dept_head;
            $postingInfo['working_at'] = $lastIncrementInfo->working_at;


            if (!empty($employeePosting)) {
                EmployeePosting::where('employee_id', $employee_id)->update($postingInfo);

            } else {
                EmployeePosting::create($postingInfo);
            }
            $postingId = $employeePosting->id;


            $userBranchUpdate['branch_id'] = $lastIncrementInfo->branch_id;
            $userBranchUpdateRole['role_id'] = empty($postingInfo['br_head']) ? 21 : 2;

            $branch_name = Branch::where('id', $lastIncrementInfo->branch_id)->first();
            $userBranchUpdate['branch_name'] = $branch_name->branch_name;


            User::where('employee_id', $employee_id)->update($userBranchUpdate, $userBranchUpdateRole);
            EmployeeDetails::where('employee_id', $employee_id)->update($userBranchUpdate);


            $postingHistory['approved_date'] = Carbon::now();
            $postingHistory['posting_status'] = '1';
            $postingHistory['approved_by'] = auth()->user()->id;
            $postingHistory['is_current'] = '2';
            $postingHistory['posting_id'] = $postingId;
            EmployeePostingHistory::where('employee_id', $employee_id)->where('posting_status', '2')->where('is_current', '1')
                ->update($postingHistory);


            $branchHead = BrDivHead::where('branch_id', $lastIncrementInfo->branch_id)->first();
            $clusterHeadInfo = ClusterHead::where('posting_id', $postingId)->first();

            if ($lastIncrementInfo->br_head == 2) {
                if (!empty($branchHead)) {
                    $brHeadS['status'] = $lastIncrementInfo->br_head;
                    BrDivHead::where('branch_id', $employeePosting->branch_id)
                        ->where('posting_id', $postingId)->update($brHeadS);
                }
            } else {
                $brHead['start_date'] = $lastIncrementInfo->effective_date;
                $brHead['status'] = $lastIncrementInfo->br_head;
                $brHead['posting_id'] = $postingId;
                $brHead['branch_id'] = $lastIncrementInfo->branch_id;
                if (empty($branchHead)) {
                    BrDivHead::create($brHead);
                } else {
                    BrDivHead::where('branch_id', $lastIncrementInfo->branch_id)
                        ->where('status', 2)
                        ->update($brHead);
                }
            }

            if ($lastIncrementInfo->cluster_head == 2) {
                if (!empty($clusterHeadInfo)) {
                    $clsHeadS['status'] = $lastIncrementInfo->cluster_head;
                    ClusterHead::where('id', $clusterHeadInfo->id)->update($clsHeadS);
                }
            } else {
                $clusterHead['start_date'] = $lastIncrementInfo->effective_date;
                $clusterHead['status'] = 1;
                $clusterHead['cluster_head_id'] = $employeePosting->employee_id;
                $clusterHead['posting_id'] = $postingId;
                ClusterHead::where('id', $clusterHeadInfo->id)->where('status', 2)->update($clusterHead);
            }

            $postingHistoryUp['is_current'] = '1';

            $postingToDate = $immediateLastPosting->effective_date;
            $date_to = Carbon::parse($lastIncrementInfo->effective_date)->subDays(1);
            $postingHistoryUp['effective_date_to'] = date("d-m-Y", strtotime($date_to));


            EmployeePostingHistory::where('employee_id', $employee_id)
                ->where('effective_date', '=', $postingToDate)
                ->where('posting_status', '1')
                ->where('is_current', '2')
                ->update($postingHistoryUp);


            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Transfer / Posting Successfully Authorized.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


    /**
     * Posting History Details Check
     * @param $employee_id
     * @return Application|Factory|View
     */
    public function viewPostingHistory($employee_id)
    {
//        dd($employee_id);
        $employee = User::where('employee_id', $employee_id)->first();
        $employeePostings = EmployeePostingHistory::where('employee_id', $employee_id)
            ->where('posting_status', '2')
            ->first();
        return view('Employee::posting_view', compact('employee', 'employeePostings'));
    }

    /**
     * Current Posting View
     * @param $employee_id
     * @return Application|Factory|View
     */
    public function viewCurrentPosting($employee_id)
    {

        $employee = User::where('employee_id', $employee_id)->first();
        $employeePostings = EmployeePosting::where('employee_id', $employee_id)
            ->first();
//        dd($employeePostings);
        return view('Employee::posting_current_details', compact('employee', 'employeePostings'));
    }

    /**
     * Posting History List Check
     * @param $employee_id
     * @return Application|Factory|RedirectResponse|View
     */
    public function postingHistory($employee_id)
    {
        try {
            $postingList = EmployeePostingHistory::where('employee_id', $employee_id)
                ->orderby(DB::raw("TO_DATE(EFFECTIVE_DATE, 'DD-MM-YYYY')"), 'DESC')
                ->get();
            return view('Employee::posting_history', compact('postingList'));
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


    /**
     * Transfer Posting Cancel
     * @param $employee_id
     * @return RedirectResponse
     */
    public function cancelPosting($employee_id)
    {
        try {
            \DB::beginTransaction();
            $postingHistory['posting_status'] = '3';
            $postingHistory['approved_by'] = auth()->user()->id;
            $postingHistory['approved_date'] = Carbon::now();

            EmployeePostingHistory::where('employee_id', $employee_id)->where('posting_status', '2')->update($postingHistory);

            \DB::commit();
            return redirect()->back()->with('msg-success', 'Employee Transfer / Posting Request Canceled.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    public function editBrHeadPosting($id)
    {

        $employeeInfo = EmployeeDetails::select('employee_details.employee_name', 'employee_details.employee_id', 'employee_details.designation', 'bh.start_date', 'bh.branch_id')
            ->join('employee_posting as ep', 'ep.employee_id', '=', 'employee_details.employee_id')
            ->join('br_div_head as bh', 'ep.id', '=', 'bh.posting_id')
            ->where('bh.branch_id', $id)
            //->where('employee_details.status', 1)
            ->first();

        $branchInfo = Branch::where('id', $id)->first();

        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $employeeList = $this->makeDD($employeeData);

        $postingInfo = EmployeePosting::where('employee_id', $employeeInfo->employee_id)->first();
        $divOrBrHead = BrDivHead::where('branch_id', $id)->first();


        $head = array(
            '' => '-- Please Select --',
            '1' => 'Yes',
            '2' => 'No',
        );

        return view('Employee::br_head_edit_posting', compact('employeeInfo', 'branchInfo', 'head', 'employeeList', 'divOrBrHead'));
    }

    public function updateBrHeadPosting(Request $request, $id)
    {

        try {
            $postingInfo = EmployeePosting::where('employee_id', $request->employee_id)->first();
            $divOrBrHead = BrDivHead::where('branch_id', $id)->first();
            $start_date = str_replace('/', '-', $request->start_date);

            $data = array(
                'posting_id' => $postingInfo->id,
                'start_date' => $start_date,
                'status' => (int)$request->status
            );

            $data1 = array(
                'posting_id' => $postingInfo->id,
                'start_date' => $start_date,
                'status' => 2
            );

            if ($divOrBrHead->status == 2) {
                BrDivHead::findOrfail($divOrBrHead->id)->update($data);
            } else {
                BrDivHead::findOrfail($divOrBrHead->id)->update($data1);
                BrDivHead::findOrfail($divOrBrHead->id)->update($data);
            }
            $postingInfo->update(['br_head' => 1]);
            User::where('employee_id', $request->employee_id)->update(['role_id' => 2]);


            return Redirect()->back()->with('msg-success', 'Successfully Updated');

        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    public function createBrDivHead()
    {
        $head = array(
            '' => '-- Please Select --',
            '1' => 'Yes',
            '2' => 'No',
        );
        $branchInfo = Branch::select(DB::raw("(id || ' - ' || branch_name) branch_name"), 'id')
            ->whereRaw('id NOT IN(select BRANCH_ID from BR_DIV_HEAD)')
            ->pluck('branch_name', 'id');

        $branchList = $this->makeDD($branchInfo);

        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $employeeList = $this->makeDD($employeeData);


        return view('Employee::create_br_head_posting', compact('employeeList', 'branchList', 'head'));
    }

    public function storeBrDivHead(Request $request)
    {
        try {
            $postingInfo = EmployeePosting::where('employee_id', $request->employee_id)->first();
            $start_date = str_replace('/', '-', $request->start_date);

            $data = array(
                'branch_id' => $request->id,
                'posting_id' => $postingInfo->id,
                'start_date' => $start_date,
                'status' => (int)$request->status
            );
            $brDivHead = new BrDivHead();
            $brDivHead->fill($data)->save();
            User::where('employee_id', $request->employee_id)->update(['role_id' => 2]);
            return Redirect()->back()->with('msg-success', 'Branch/Division Head Successfully Added');
        } catch (\Exception $e) {
            \Log::info('EmployeePostingController-storeBrDivHead-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());

        }

    }


}
