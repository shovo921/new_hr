<?php

namespace App\Modules\Leave\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\Designation\Models\Designation;
use App\Modules\Employee\Models\BrDivHead;
use App\Modules\FunctionalDesignation\Models\FunctionalDesignation;
use App\Modules\Leave\Models\EmployeeLeave;
use App\Modules\Leave\Models\LeaveApplicationLog;
use App\Modules\Leave\Models\LeaveAttachment;
use App\Modules\Leave\Models\LeaveReason;
use Carbon\Carbon;

use DateTime;
use Facade\Ignition\SolutionProviders\DefaultDbNameSolutionProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;

use App\User;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeePosting;

use App\Modules\Leave\Models\EmployeeLeaveApplicationLog;
use App\Modules\LeaveType\Models\LeaveType;
use App\Modules\Leave\Models\LeaveApplication;
use App\Modules\Leave\Models\LeaveApproval;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Illuminate\View\View;

class LeaveController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "leave";
    }

    public function index()
    {

        $_SESSION['SubMenuActive'] = 'employee-leave';
        $employee_id = auth()->user()->employee_id;
        if ($employee_id == 'hradmin' || $employee_id == 'hrexecutive') {
//            $employeeLeaves = EmployeeLeave::where('leave_balance', '!=', null)->get();
            $employeeLeaves = EmployeeLeave::select('EMPLOYEE_ID', DB::raw('COUNT(*) as totalLeaves'))
                ->where('leave_balance', '!=', null)
                ->groupBy('employee_id')
                ->get();
        } else {
            $employeeLeaves = EmployeeLeave::where('employee_id', auth()->user()->employee_id)
                ->where('leave_balance', '!=', null)
                ->get();
        }


        return view('Leave::index', compact('employeeLeaves'));
    }

    /*
     * ALL Functions List Start
     */

    /**
     * This function is responsible to check the Division Head or Branch Head Name
     *
     * @return Response
     */
    public function getHeadOfDivOrBranchName($branchId)
    {
        //dd($branchId);
        return EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->join('employee_posting', 'employee_details.employee_id', '=', 'employee_posting.employee_id')
            ->join('br_div_head', 'br_div_head.posting_id', '=', 'employee_posting.id')
            ->where('br_div_head.branch_id', $branchId)
            ->where('br_div_head.status', '=', 1)
            ->pluck('employee_name', 'employee_id');
    }

    /**
     * This function is responsible to check the Division Head or Branch Head Employee ID
     *
     * @return Response
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
     * This function is responsible to check the Posting Information
     *
     * @return Response
     */
    public function getEmpPostingInfo($empId)
    {
        $postingInfo = EmployeePosting::select('employee_details.employee_id', 'employee_details.employee_name', 'employee_details.branch_name',
            'employee_details.designation', 'employee_posting.functional_designation', 'employee_posting.br_head', 'employee_posting.branch_id', 'employee_posting.br_division_id')
            ->join('employee_details', 'employee_details.employee_id', '=', 'employee_posting.employee_id')
            ->where('employee_details.employee_id', $empId)->first();
        return $postingInfo;
    }

    /**
     * This function is responsible to check the Functional Designation
     *
     * @return Response
     */
    public function getEmpFunctionalDesignationInfo($empId)
    {
        $fDesignationInfo = FunctionalDesignation::select('functional_designations.designation')
            ->join('employee_posting', 'employee_posting.functional_designation', '=', 'functional_designations.id')
            ->where('employee_posting.employee_id', $empId)->first();
        return $fDesignationInfo;
    }

    /**
     * This function is responsible to check the Branch Information
     *
     * @return Response
     */
    public static function getEmpBranchInfo($empId)
    {
        $branchInfo = EmployeePosting::select('employee_details.branch_name')
            ->join('employee_details', 'employee_details.employee_id', '=', 'employee_posting.employee_id')
            ->where('employee_details.employee_id', $empId)->first();
        return $branchInfo;
    }

    /**
     * This function is responsible to check the Employee Information
     *
     * @return Response
     */
    public function getEmpInfo($empId)
    {
        $empInfo = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->where('employee_details.employee_id', $empId)
            ->pluck('employee_name', 'employee_id');
        return $empInfo;
    }

    /**
     * This function is responsible to check the Employee Information
     *
     * @return Response
     */
    public function getLeaveRemarks($leaveId, $empId)
    {
        $leaveRemarks = EmployeeLeaveApplicationLog::select('leave_applications_log.remarks', 'leave_applications_log.leave_reliever')
            ->where('leave_applications_log.leave_id', $leaveId)
            ->where('leave_applications_log.leave_reliever', $empId)->first();
        return $leaveRemarks;
    }

    /**
     * This function is responsible to check the Leave Balance
     *
     * @return Response
     */
    public function getLeaveBalance($empId, $leaveId)
    {
        $leaveBalance = EmployeeLeave::select(DB::raw('leave_types.leave_type,employee_leave_infos.leave_balance,employee_leave_infos.last_forwarded_leave,employee_leave_infos.leave_taken'))
            ->join('leave_types', 'employee_leave_infos.leave_type_id', '=', 'leave_types.id')
            ->where('employee_id', $empId)->where('leave_type_id', $leaveId)->first();
        return $leaveBalance;
    }

    /**
     * @param $empId
     * @return \Illuminate\Support\Collection
     */
    public function getLeaveTypes($empId)
    {
        $empLeaveTypes = DB::table('leave_types')
            ->select('leave_types.leave_type', 'leave_types.id')
            ->join('employee_leave_infos', 'leave_types.id', '=', 'employee_leave_infos.leave_type_id')
            ->where('leave_types.status', 1)
            ->where('employee_leave_infos.employee_id', '=', $empId)
            ->where('employee_leave_infos.leave_balance', '!=', null)
            ->orderby('leave_types.id')
            ->pluck('leave_type', 'id');
        return $empLeaveTypes;
    }

    /*
     * ALL Functions List End
     */

    /**
     * This is the storage of Leave Attachments
     * Created on 18-07-2022
     * Last modified on 26-09-2022
     * @param $id
     * @param $attachedFile
     * @return void
     */
    public function storeLeaveAttachment($id, $attachedFile)
    {
        $attachment = new LeaveAttachment();

        if (empty($id)) {
            $attachment->fill($attachedFile)->save();
        } else {
            $attachment->where('id', $id)->update($attachedFile);
        }
    }

    /**
     * Show the form for creating a new resource.
     * Created on 05-07-2022
     * Last modified on 20-09-2022
     * @return Response
     */
    public function create()
    {


        $_SESSION['SubMenuActive'] = 'leave-apply';

        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive',
        );

        $leaveLocation = array(
            '1' => 'Inside The Country',
            '2' => 'Outside The Country',
        );
        $employee_id = auth()->user()->employee_id;


        $leaveApplication = LeaveApplication::where('employee_id', $employee_id)->orderby('created_at', 'desc')->first();
        $leaveReason = LeaveReason::pluck('reason_desc', 'reason_desc');

        if (empty($leaveApplication->leave_status) || $leaveApplication->leave_status == 4 || $leaveApplication->leave_status == 3) {


            $postingInfo = $this->getEmpPostingInfo($employee_id);
            $leaveTypes = $this->makeDD($this->getLeaveTypes($employee_id));
            $singlePostingCheck = EmployeePosting::select('employee_details.employee_id')
                ->join('employee_details', 'employee_details.employee_id', '=', 'employee_posting.employee_id')
                ->where('employee_details.employee_id', '<>', $employee_id)
                ->where('employee_posting.branch_id', $postingInfo->branch_id)
                ->where('employee_details.status', 1)
                ->get();

            if (count($singlePostingCheck) > 1) {
                $responsibleUser = $this->makeDD(DB::table('employee_details')
                    ->select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
                    ->join('employee_posting', 'employee_details.employee_id', '=', 'employee_posting.employee_id')
                    ->join('designation', 'designation.id', '=', 'employee_details.designation_id')
                    ->where('employee_posting.branch_id', $postingInfo->branch_id)
                    ->where('employee_details.status', '1')
                    ->where('employee_details.employee_id', '!=', $employee_id)
                    ->orderBy('designation.seniority_order', 'ASC')
                    ->pluck('employee_name', 'employee_id'));
            } else {
                $responsibleUser = $this->getHeadOfDivOrBranchName($postingInfo->branch_id);
            }

            return view('Leave::create', compact('postingInfo', 'leaveReason', 'leaveTypes', 'leaveLocation', 'responsibleUser'));
        } else if ($leaveApplication->leave_status == 1 || $leaveApplication->leave_status == 2 || $leaveApplication->leave_status == 5 || $leaveApplication->leave_status == 6 || $leaveApplication->leave_status == 7 || $leaveApplication->leave_status == 8) {
            return Redirect()->back()->with('msg-error', 'You have a Pending Application');
        }


    }

    /**
     * Store a newly created resource in storage.
     * Created on 15-07-2022
     * Last modified on 19-09-2022
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $inputs = $request->all();


        $validator = \Validator::make($inputs, array(
            'employee_id' => 'required',
            /*'start_date' => 'required',
            'end_date' => 'required',*/
            'total_days' => 'required|int',
            'leave_type_id' => 'required|int',
            'next_joining_date' => 'required',
            'reason_of_leave' => 'required',
            'contact_info_during_leave' => 'required',
            'responsible_to' => 'required',
            'attachment' => 'mimes:jpg,jpeg,png,pdf,docx|max:5120',
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        if (empty($request->start_date) || empty($request->end_date)) {
            $str_date = $request->start_date1;
            $end_date = $request->end_date1;
        } else {
            $str_date = $request->start_date;
            $end_date = $request->end_date;
        }

        $START_DATE = date("Y-m-d", strtotime($str_date));
        $END_DATE = date("Y-m-d", strtotime($end_date));
        $NEXT_JOINING_DATE = date("Y-m-d", strtotime($request->next_joining_date));

        $date1 = date_create($START_DATE);
        $date2 = date_create($END_DATE);

        $diff = date_diff($date1, $date2);

        $total_days = $diff->format("%a");
        $total_days = $total_days + 1;
        $leaveTypeInfo = LeaveType::findOrFail($request->leave_type_id);
        $max_leave_taken = (int)$leaveTypeInfo->max_taken_at_a_time;
        $leaveBalance = EmployeeLeave::where('employee_id', $request->employee_id)->where('leave_type_id', $request->leave_type_id)->first();

        if ((int)$leaveBalance->last_forwarded_leave >= $total_days) {
            if ($total_days <= $max_leave_taken) {
                $leaveApplication = new LeaveApplication();
                $data = array('employee_id' => $request->employee_id,
                    'start_date' => $START_DATE,
                    'end_date' => $END_DATE,
                    'total_days' => $request->total_days,
                    'leave_type_id' => $request->leave_type_id,
                    'next_joining_date' => $NEXT_JOINING_DATE,
                    'reason_of_leave' => $request->reason_of_leave,
                    'contact_info_during_leave' => $request->contact_info_during_leave,
                    'responsible_to' => $request->responsible_to,
                    'waiting_for' => $request->responsible_to,
                    'leave_location' => $request->leave_location,
                    'country_name' => $request->country_name,
                    'passport_no' => $request->passport_no,
                    'leave_status' => 1,
                    'created_at' => Carbon::now());

                $leaveApplication->fill($data)->save();
                if (!empty($request->attachment)) {
                    $path = public_path('uploads/employeedata/' . $request->employee_id . '/leave');
                    $fileName = $leaveApplication->id . '.' . $request->attachment->extension();
                    $request->attachment->move($path, $fileName);
                    $attachedFile = array(
                        'leave_id' => $leaveApplication->id,
                        'attachment' => $fileName,
                        'receiving_date' => Carbon::now(),
                    );

                    $this->storeLeaveAttachment(null, $attachedFile);
                } else {
                    return Redirect()->to('allApplication')->with('msg-success', 'Leave Application Successfully Submitted');
                }
                return Redirect()->to('allApplication')->with('msg-success', 'Leave Application Successfully Submitted');

            }
        } else {
            return Redirect()->back()->with('msg-error', 'Total days not matched with the date range or exceeds the limit.');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

        $leaveApplication = LeaveApplication::findOrFail($id);
        $_SESSION['SubMenuActive'] = 'leave-apply';
        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive',
        );

        $leaveLocation = array(
            '1' => 'Inside The Country',
            '2' => 'Outside The Country',
        );

        $employee_id = auth()->user()->employee_id;

        $postingInfo = $this->getEmpPostingInfo($employee_id);
        $leaveTypes = $this->makeDD($this->getLeaveTypes($employee_id));
        $leaveReason = LeaveReason::pluck('reason_desc', 'reason_desc');

        $responsibleUser = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->join('employee_posting', 'employee_details.employee_id', '=', 'employee_posting.employee_id')
            ->where('employee_posting.branch_id', $postingInfo->branch_id)
            ->where('employee_details.status', '1')
            /*->where('employee_posting.br_division_id', $postingInfo->br_division_id)*/
            ->where('employee_details.employee_id', '!=', $employee_id)
            ->pluck('employee_name', 'employee_id');


        return view('Leave::edit', compact('leaveApplication', 'leaveReason', 'leaveLocation', 'postingInfo', 'leaveTypes', 'responsibleUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $leave = LeaveApplication::findOrFail($id);

        $inputs = $request->all();
        //dd($inputs);

        $validator = \Validator::make($inputs, array(
            'employee_id' => 'required',
            /*'start_date' => 'required',
            'end_date' => 'required',*/
            'total_days' => 'required|int',
            'leave_type_id' => 'required|int',
            'next_joining_date' => 'required',
            'reason_of_leave' => 'required',
            'contact_info_during_leave' => 'required',
            'responsible_to' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        if (empty($request->start_date) || empty($request->end_date)) {
            $str_date = $request->start_date1;
            $end_date = $request->end_date1;
        } else {
            $str_date = $request->start_date;
            $end_date = $request->end_date;
        }

        $START_DATE = date("Y-m-d", strtotime($str_date));
        $END_DATE = date("Y-m-d", strtotime($end_date));
        $NEXT_JOINING_DATE = date("Y-m-d", strtotime($request->next_joining_date));

        $date1 = date_create($START_DATE);
        $date2 = date_create($END_DATE);

        $diff = date_diff($date1, $date2);

        $total_days = $diff->format("%a");

        $total_days = $total_days + 1;

        $leaveTypeInfo = LeaveType::findOrFail($request->leave_type_id);
        $max_leave_taken = (int)$leaveTypeInfo->max_taken_at_a_time;

        if ($total_days <= $max_leave_taken) {

            if ($request->leave_location == 1) {
                $country_name = '';
                $passport_no = '';
            } else {
                $country_name = $request->country_name;
                $passport_no = $request->passport_no;
            }
            $data = array('START_DATE' => $START_DATE,
                'END_DATE' => $END_DATE,
                'TOTAL_DAYS' => $request->total_days,
                'LEAVE_TYPE_ID' => $request->leave_type_id,
                'NEXT_JOINING_DATE' => $NEXT_JOINING_DATE,
                'REASON_OF_LEAVE' => $request->reason_of_leave,
                'CONTACT_INFO_DURING_LEAVE' => $request->contact_info_during_leave,
                'RESPONSIBLE_TO' => $request->responsible_to,
                'WAITING_FOR' => $request->responsible_to,
                'leave_location' => $request->leave_location,
                'country_name' => $country_name,
                'passport_no' => $passport_no,
                'UPDATED_AT' => Carbon::now());


            LeaveApplication::where('id', $id)->update($data);

            if (!empty($request->attachment)) {
                $path = public_path('uploads/employeedata/' . $leave->employee_id . '/leave');
                $fileName = $id . '.' . $request->attachment->extension();
                $request->attachment->move($path, $fileName);
                $attachedFile = array(
                    'leave_id' => $id,
                    'attachment' => $fileName,
                    'receiving_date' => Carbon::now(),
                );
                $this->storeLeaveAttachment($id, $attachedFile);
            } else {
                return Redirect()->to('allApplication')->with('msg-success', 'Leave Application Successfully Submitted');
            }

            return Redirect()->to('allApplication')->with('msg-success', 'Leave Successfully Updated');
        } else {
            return Redirect()->back()->with('msg-error', 'Total days not matched with the date range or exceeds the limit.');
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
        try {
            Leave::destroy($id);
            return Redirect()->route('leave.index')->with('msg-success', 'Successfully Deleted.');
        } catch (\Exception $e) {
            return Redirect()->route('leave.index')->with('msg-error', "This item is already used.");
        }
    }

    public function getLeaveTotalDays(Request $request)
    {
        $start_date = date("Y-m-d", strtotime($request->start_date));
        $end_date = date("Y-m-d", strtotime($request->end_date));

        if ($start_date <= $end_date) {
            $date1 = date_create($start_date);
            $date2 = date_create($end_date);
            $diff = date_diff($date1, $date2);

            $next_joining_date = date('m/d/Y', strtotime($end_date . ' +1 day'));

            $total_days = $diff->format("%a");

            $data['status'] = 'success';
            $data['total_days'] = $total_days + 1;
            $data['next_joining'] = $next_joining_date;
        } else {
            $data['status'] = 'error';
        }
        return response()->json($data);
    }

    public function allApplication(Request $request)
    {
        $_SESSION['SubMenuActive'] = 'all-applications';

        $allLeaveApplications = $this->__allApplicationFilter($request);


        $leaveTypes = $this->makeDD(LeaveType::pluck('leave_type', 'id'));
        if (auth()->user()->role_id == '1' || auth()->user()->role_id == '3' || auth()->user()->role_id == '5') {
            $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->pluck('employee_name', 'employee_id');

        } else {
            $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->where('employee_id', auth()->user()->employee_id)
                ->pluck('employee_name', 'employee_id');
        }
        $leave_status = array(
            '' => '---Please Select---',
            '1' => 'Pending',
            '2' => 'Processing',
            '5' => 'Waiting For HR Officer',
            '6' => 'Waiting For Deputy Head HR',
            '7' => 'Waiting For HR Head ',
            '8' => 'Waiting For Managing Director',
            '3' => 'Approved',
            '4' => 'Cancelled',
        );

        return view("Leave::all_application", compact('allLeaveApplications', 'leave_status', 'leaveTypes', 'allEmployees'));
    }

    private function __allApplicationFilter($request)
    {
        $employeeId = auth()->user()->employee_id;
        if ($employeeId == 'hradmin' || $employeeId == 'hrexecutive' || $employeeId == 'hrleaveofficer' || $employeeId == 'hrhead' || $employeeId == 'hrdeputyhead' || $employeeId == 'md') {
            $allLeaveApplications = LeaveApplication::query();

            if ($request->filled('employee_id')) {
                $allLeaveApplications->where('employee_id', $request->employee_id);
            }

            if ($request->filled('leave_status')) {
                $allLeaveApplications->where('leave_status', $request->leave_status);
            }
            $application_date = date("d-M-Y", strtotime($request->applied_date));
            //$application_date = $application_date.' 00:00:00';
            $application_date2 = $application_date . ' 11:59:59';
            //dd($application_date);
            if ($request->filled('applied_date')) {
                $allLeaveApplications->where('created_at', '=', $application_date);
                //$allLeaveApplications->whereBetween('created_at',[$application_date,$application_date2]);
                //$allLeaveApplications->whereRaw("TO_DATE(created_at) = ".'$application_date'." ");
                // $allLeaveApplications->whereBetween('created_at',[$application_date,$application_date2]);
            }

            if ($request->filled('from_date')) {
                $allLeaveApplications->where('start_date', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $allLeaveApplications->where('end_date', '<=', $request->to_date);
            }
            if ($request->filled('leave_type')) {
                $allLeaveApplications->where('leave_type_id', $request->leave_type);
            }

        } else {
            $allLeaveApplications = LeaveApplication::query();

            if ($request->filled('employee_id')) {
                $allLeaveApplications->where('employee_id', $request->employee_id);
            }

            if ($request->filled('from_date')) {
                $allLeaveApplications->where('start_date', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $allLeaveApplications->where('end_date', '<=', $request->to_date);
            }
            if ($request->filled('leave_type')) {
                $allLeaveApplications->where('leave_type_id', $request->leave_type);
            }

            $allLeaveApplications->where('employee_id', $employeeId);

        }

        return $allLeaveApplications->orderBy('created_at', 'desc')->paginate(10);
    }

    public function waitingList(Request $request)
    {

        $_SESSION['SubMenuActive'] = 'waiting-for';

        $waitingLeaveApplications = $this->__waitingfilter($request);
        //dd($waitingLeaveApplications);

        $leaveTypes = $this->makeDD(LeaveType::pluck('leave_type', 'id'));
        if (auth()->user()->role_id == '1' || auth()->user()->role_id == '3') {
            $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->pluck('employee_name', 'employee_id');
        } else {
            $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->where('employee_id', auth()->user()->employee_id)
                ->pluck('employee_name', 'employee_id');
        }
        $employeeList = $this->makeDD($allEmployees);

        return view("Leave::waiting_application", compact('waitingLeaveApplications', 'leaveTypes', 'employeeList'));
    }

    private function __waitingfilter($request)
    {
        $employee_id = auth()->user()->employee_id;
        if (auth()->user()->role_id == '1' || auth()->user()->role_id == '3') {
            $waitingLeaveApplications = LeaveApplication::where('waiting_for', 'like', '%hr%')
                ->where('leave_status', '=', '2');

        } else {
            $waitingLeaveApplications = LeaveApplication::where('waiting_for', $employee_id)->whereIn('leave_status', ['1', '2']);
        }

        if ($request->filled('employee_id')) {
            $waitingLeaveApplications->where('employee_id', $request->employee_id);
        }
        if ($request->filled('from_date')) {
            $waitingLeaveApplications->where('start_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $waitingLeaveApplications->where('start_date', '<=', $request->to_date);
        }
        //dd($waitingLeaveApplications);

        return $waitingLeaveApplications->orderBy('start_date', 'desc')->paginate(10);
    }

    public function waitingListHR(Request $request)
    {
        $_SESSION['SubMenuActive'] = 'waiting-for-hr';

        $waitingLeaveApplications = $this->__waitingfilterHR($request);
        //dd($waitingLeaveApplications);

        $leaveTypes = $this->makeDD(LeaveType::pluck('leave_type', 'id'));
        $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');
        $employeeList = $this->makeDD($allEmployees);

        return view("Leave::hr_waiting_application", compact('waitingLeaveApplications', 'leaveTypes', 'employeeList'));
    }

    private function __waitingfilterHR($request)
    {
        $employee_id = auth()->user()->employee_id;

        if ($employee_id === 'hrleaveofficer') {
            $waitingLeaveApplications = LeaveApplication::where('waiting_for', '=', 'hrleaveofficer')->where('leave_status', '=', '5');
        } elseif ($employee_id == 'hrdeputyhead') {
            $waitingLeaveApplications = LeaveApplication::where('waiting_for', '=', 'hrdeputyhead')->where('leave_status', '=', '6');
        } elseif ($employee_id == 'hrhead') {
            $waitingLeaveApplications = LeaveApplication::where('waiting_for', '=', 'hrhead')->where('leave_status', '=', '7');
        } else {
            $waitingLeaveApplications = LeaveApplication::where('waiting_for', '=', 'md')->where('leave_status', '=', '8');
        }
        if ($request->filled('employee_id')) {
            $waitingLeaveApplications->where('employee_id', $request->employee_id);
        }
        if ($request->filled('from_date')) {
            $waitingLeaveApplications->where('start_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $waitingLeaveApplications->where('start_date', '<=', $request->to_date);
        }
        if ($request->filled('applied_date')) {
            $waitingLeaveApplications->where('created_at', '<=', $request->created_at);
        }

        return $waitingLeaveApplications->orderBy('created_at', 'desc')->paginate(30);
    }

    public function approveLeave($id)
    {
        $employee_id = auth()->user()->employee_id;
        $application = LeaveApplication::findOrFail($id);

        if ($employee_id == $application->waiting_for) {

            $postingInfo = EmployeePosting::where('employee_id', $application->employee_id)->first();

            if ($employee_id == $postingInfo->reporting_officer) {
                // dd('Test Ok');
                $headOfBranchDivision = EmployeePosting::where('branch_id', $postingInfo->branch_id)->where('br_division_id', $postingInfo->br_division_id)->where('functional_designation', '2');
                if ($headOfBranchDivision->count() > 0) {
                    $headOfBranchDivisionInfo = $headOfBranchDivision->first();

                    $upapplication['waiting_for'] = $headOfBranchDivisionInfo->employee_id;
                } else {
                    $upapplication['waiting_for'] = 'HR';
                }
            } else {
                $upapplication['waiting_for'] = $postingInfo->reporting_officer;
            }

            $upapplication['leave_status'] = '2';

            LeaveApplication::where('id', $id)->update($upapplication);

            return Redirect()->to('leave')->with('msg-success', 'Leave application approved.');
        } else {
            return Redirect()->back()->with('msg-error', 'You are not eligible to approve this leave application');
        }
    }

    /**
     * This function is used forLeave Reliever Updation
     * @param $id
     * @return Application|Factory|View
     */
    public function leaveRelieverApprove($id)
    {

        $leaveApplication = LeaveApplication::findOrFail($id);

        $leaveLocation = array(
            '1' => 'Within Country',
            '2' => 'Outside The Country',
        );
        $_SESSION['SubMenuActive'] = 'leave-apply';
        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive',
        );
        $employee_id = auth()->user()->employee_id;
        $postingInfo = $this->getEmpPostingInfo($leaveApplication->employee_id);

        $designation24 = $this->getHeadOfDivOrBranchEmpId($postingInfo->branch_id);

        $leaveTypes = $this->makeDD(LeaveType::pluck('leave_type', 'id'));
        $leaveBalance = EmployeeLeave::select(DB::raw('leave_types.leave_type,employee_leave_infos.leave_balance,employee_leave_infos.last_forwarded_leave,employee_leave_infos.leave_taken'))
            ->join('leave_types', 'employee_leave_infos.leave_type_id', '=', 'leave_types.id')
            ->where('employee_id', $leaveApplication->employee_id)->where('leave_type_id', $leaveApplication->leave_type_id)->first();

        if ($designation24->employee_id == $leaveApplication->employee_id) {
            $divisionHead = User::select(DB::raw("(users.employee_id || ' - ' || users.name) employee_name"), 'users.employee_id')
                ->where('users.employee_id', '=', 'hrleaveofficer')
                ->pluck('employee_name', 'employee_id');
        } else {
            $divisionHead = $this->getHeadOfDivOrBranchName($postingInfo->branch_id);
        }

        $leaveReliever = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->where('employee_details.employee_id', $leaveApplication->responsible_to)
            ->pluck('employee_name', 'employee_id');
        $leaveApplicationLogResposible = EmployeeLeaveApplicationLog::select('remarks')->where('leave_id', $id)
            ->where('leave_reliever', $leaveApplication->responsible_to)->first();

        $leaveApplicationLogDiviHead = EmployeeLeaveApplicationLog::select('remarks')->where('leave_id', $id)
            ->where('leave_reliever', '!=', $leaveApplication->responsible_to)->first();


        return view('Leave::leave_reliever', compact('leaveApplication', 'leaveLocation', 'leaveBalance', 'leaveReliever', 'leaveApplicationLogResposible', 'leaveApplicationLogDiviHead', 'postingInfo', 'leaveTypes', 'divisionHead'));
    }

    /**
     * This function is liable for viewing the HR Approval Process
     * Created Date :29-06-2022
     * @param $id
     * @return Application|Factory|View
     */
    public function leaveHrApprove($id)
    {
        $_SESSION['SubMenuActive'] = 'leave-apply';
        $leaveLocation = array(
            '1' => 'Inside The Country',
            '2' => 'Outside The Country',
        );
        $leaveApprovalStatus = array(
            '1' => 'Yes',
            '2' => 'No',
        );
        $leaveApplication = LeaveApplication::findOrFail($id);

        $empPosting = $this->getEmpPostingInfo($leaveApplication->employee_id);
        $fDesignationInfo = $this->getEmpFunctionalDesignationInfo($leaveApplication->employee_id);
        $leaveReliever = $this->getEmpInfo($leaveApplication->responsible_to);
        $headOfDivOrBranchName = $this->getHeadOfDivOrBranchName($empPosting->branch_id);
        $headOfDivOrBranchEmpId = $this->getHeadOfDivOrBranchEmpId($empPosting->branch_id);
        $leaveBalance = $this->getLeaveBalance($leaveApplication->employee_id, $leaveApplication->leave_type_id);
        $leaveRelieverRemarks = $this->getLeaveRemarks($id, $leaveApplication->responsible_to);
        $headOfDivOrBranchRemarks = $this->getLeaveRemarks($id, $headOfDivOrBranchEmpId->employee_id);
        $hrLeaveOfficerRemarks = $this->getLeaveRemarks($id, 'hrleaveofficer');
        $hrDeputyHeadRemarks = $this->getLeaveRemarks($id, 'hrdeputyhead');
        $hrHeadRemarks = $this->getLeaveRemarks($id, 'hrhead');
        $mdRemarks = $this->getLeaveRemarks($id, 'md');
        return view('Leave::final_leave_reliever', compact('leaveApplication', 'fDesignationInfo', 'leaveApprovalStatus', 'empPosting', 'leaveBalance', 'leaveLocation', 'leaveReliever', 'headOfDivOrBranchName', 'leaveReliever', 'leaveRelieverRemarks', 'headOfDivOrBranchRemarks', 'hrLeaveOfficerRemarks', 'hrDeputyHeadRemarks', 'hrHeadRemarks', 'mdRemarks'));
    }

    /**
     * This function is liable for viewing the HR Approval Update Process
     * Created Date :29-06-2022
     *  1=Pending(Reliever),2=Processing(Div/Branch Head),3=Approved, 4=Canceled,
     * 5=HR Officer,6=HR Deputy,7=HR Head,8=MD
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveHrApproveUpdate(Request $request, $id)
    {
        try {
            switch ($request->submit) {
                case 'Checked':
                    $leave = LeaveApplication::findOrFail($id);
                    $employee_id = auth()->user()->employee_id;
                    if ($employee_id == 'hrleaveofficer' && !empty($request->hr_remarks)) {
                        $leave_status = 7;
                        $reliever = 'hrleaveofficer';
                        $remarks = $request->hr_remarks;
                        $data = array(
                            'LEAVE_STATUS' => $leave_status,
                            'WAITING_FOR' => 'hrhead',
                            'UPDATED_AT' => Carbon::now());
                    }
                    $this->leaveApplicationAndLogUpdate($leave->id, $reliever, $remarks, $data,$employee_id);
                    return Redirect()->to('waiting-list')->with('msg-success', 'Leave Successfully Updated');
                    break;
                case 'Verified':
                    $leave = LeaveApplication::findOrFail($id);
                    $employee_id = auth()->user()->employee_id;

                    if ($employee_id == 'hrdeputyhead' && !empty($request->hr_deputy_remarks)) {
                        $leave_status = 7;
                        $reliever = 'hrdeputyhead';
                        $remarks = $request->hr_deputy_remarks;
                        $data = array(
                            'LEAVE_STATUS' => $leave_status,
                            'WAITING_FOR' => 'hrhead',
                            'UPDATED_AT' => Carbon::now());
                    }
                    $this->leaveApplicationAndLogUpdate($leave->id, $reliever, $remarks, $data,$employee_id);
                    return Redirect()->to('waiting-list')->with('msg-success', 'Leave Successfully Updated');
                    break;
                case 'Approve / Forwarded':
                    $leave = LeaveApplication::findOrFail($id);
                    $employee_id = auth()->user()->employee_id;
                    if ($employee_id == 'hrhead' && !empty($request->hr_head_remarks)) {
                        if ($request->leave_approval == 1) {
                            $leave_status = 3;
                            $reliever = 'hrhead';
                            $remarks = $request->hr_head_remarks;
                            $data = array(
                                'LEAVE_STATUS' => $leave_status,
                                'WAITING_FOR' => 'hrhead',
                                'UPDATED_AT' => Carbon::now());
                        } else {
                            $leave_status = 8;
                            $reliever = 'hrhead';
                            $remarks = $request->hr_head_remarks;
                            $data = array(
                                'LEAVE_STATUS' => $leave_status,
                                'WAITING_FOR' => 'md',
                                'UPDATED_AT' => Carbon::now());
                        }
                    }
                    $this->leaveApplicationAndLogUpdate($leave->id, $reliever, $remarks, $data,$employee_id);
                    return Redirect()->to('waiting-list')->with('msg-success', 'Leave Successfully Updated');
                    break;
                case 'Approve':
                    $leave = LeaveApplication::findOrFail($id);
                    $employee_id = auth()->user()->employee_id;
                    if ($employee_id == 'md' && !empty($request->md_remarks)) {
                        $leave_status = 3;
                        $reliever = 'md';
                        $remarks = $request->md_remarks;
                        $data = array(
                            'LEAVE_STATUS' => $leave_status,
                            'WAITING_FOR' => $reliever,
                            'UPDATED_AT' => Carbon::now());
                    }
                    $this->leaveApplicationAndLogUpdate($leave->id, $reliever, $remarks, $data,$employee_id);
                    return Redirect()->to('waiting-list')->with('msg-success', 'Leave Successfully Updated');
                    break;
                case 'Cancel':
                    $leave = LeaveApplication::findOrFail($id);
                    $employee_id = auth()->user()->employee_id;
                    if ($employee_id == 'hrleaveofficer' && !empty($request->hr_remarks)) {
                        $reliever = 'hrleaveofficer';
                        $remarks = $request->hr_remarks;
                        $leave_status = 4;
                        $data = array(
                            'LEAVE_STATUS' => $leave_status,
                            'WAITING_FOR' => $reliever,
                            'UPDATED_AT' => Carbon::now());
                    } elseif ($employee_id == 'hrdeputyhead' && !empty($request->hr_deputy_remarks)) {
                        $reliever = 'hrdeputyhead';
                        $remarks = $request->hr_deputy_remarks;
                        $leave_status = 4;
                        $data = array(
                            'LEAVE_STATUS' => $leave_status,
                            'WAITING_FOR' => $reliever,
                            'UPDATED_AT' => Carbon::now());
                    } elseif ($employee_id == 'hrhead' && !empty($request->hr_head_remarks)) {

                        $reliever = 'hrhead';
                        $remarks = $request->hr_head_remarks;
                        $leave_status = 4;
                        $data = array(
                            'LEAVE_STATUS' => $leave_status,
                            'WAITING_FOR' => $reliever,
                            'UPDATED_AT' => Carbon::now());
                    } elseif ($employee_id == 'md' && !empty($request->md_remarks)) {
                        $reliever = 'md';
                        $remarks = $request->md_remarks;
                        $leave_status = 4;
                        $data = array(
                            'LEAVE_STATUS' => $leave_status,
                            'WAITING_FOR' => $reliever,
                            'UPDATED_AT' => Carbon::now());

                    }
                    $this->leaveApplicationAndLogUpdate($leave->id, $reliever, $remarks, $data,$employee_id);
                    return Redirect()->to('waiting-list')->with('msg-success', 'Leave application canceled.');
                    break;
            }
        } catch (\Exception $e) {
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    /**
     * This function is liable for Leave Log Update
     * Created Date :29-06-2022
     * @param $leaveId
     * @param $leaveReliever
     * @param $leaveRemarks
     * @param $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveApplicationAndLogUpdate($leaveId, $leaveReliever, $leaveRemarks, $data,$relieverlog)
    {

        try {
            $leaveApplicationLog = new EmployeeLeaveApplicationLog();
            $leaveApplicationLog->leave_id = $leaveId;
            $leaveApplicationLog->leave_reliever = $relieverlog;
            $leaveApplicationLog->remarks = $leaveRemarks;
            $leaveApplicationLog->updated_at = Carbon::now();

            $leaveApplicationLog->save();

            LeaveApplication::where('id', $leaveId)->update($data);

        } catch (\Exception $e) {
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Leave Status Description
     * 1=Pending(Reliever),2=Processing(Div/Branch Head),3=Approved, 4=Canceled,
     * 5=HR Officer,6=HR Deputy,7=HR Head,8=MD
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveRelieverApproveUpdate(Request $request, $id)
    {


        try {

            $leave = LeaveApplication::findOrFail($id);
            $employee_id = auth()->user()->employee_id;

            $emaployeePostingInfo = EmployeePosting::where('employee_id', $employee_id)->first();
            $brHead = BrDivHead::where('posting_id', $emaployeePostingInfo->id)->where('status', 1)->first();
            $headOfDivOrBranchEmpId = $this->getHeadOfDivOrBranchEmpId($emaployeePostingInfo->branch_id);

            if ($leave->leave_location == 1) {
                if ($leave->total_days <= 10) {

                    if (!empty($brHead)) {
                        if ($leave->leave_type_id == 1 || $leave->leave_type_id == 2 || $leave->leave_type_id == 3) {
                            $leave_status = 3;
                            $reliever = $leave->waiting_for;
                            $remarks = $request->division_head_remarks;
                        } else {
                            $leave_status = 5;
                            $reliever = 'hrleaveofficer';
                            $remarks = $request->division_head_remarks;
                        }


                    } else {
                        $leave_status = 2;
                        $reliever = $request->responsible_to_div_head;
                        $remarks = $request->line_manager_remarks;
                    }

                } else {
                    if (empty($brHead)) {
                        if ($request->responsible_to_div_head == 'hrleaveofficer') {
                            $leave_status = 5;
                        } else {
                            $leave_status = 2;
                        }
                        $reliever = $request->responsible_to_div_head;
                        $remarks = $request->line_manager_remarks;

                    } else {
                        $leave_status = 5;
                        $reliever = 'hrleaveofficer';
                        $remarks = $request->division_head_remarks;
                    }
                }
            }else{
                if (!empty($brHead)) {
                    $leave_status = 5;
                    $reliever = 'hrleaveofficer';
                    $remarks = $request->division_head_remarks;
                }else{
                    $leave_status = 2;
                    $reliever = $request->responsible_to_div_head;
                    $remarks = $request->line_manager_remarks;
                }
            }


            if ($leave->employee_id == $headOfDivOrBranchEmpId->employee_id) {
                $data = array(
                    'LEAVE_STATUS' => 5,
                    'WAITING_FOR' => $reliever,
                    'UPDATED_AT' => Carbon::now());
            } else {
                $data = array(
                    'LEAVE_STATUS' => $leave_status,
                    'WAITING_FOR' => $reliever,
                    'UPDATED_AT' => Carbon::now());
            }

            try {
                $relieverlog=$employee_id;
                $this->leaveApplicationAndLogUpdate($leave->id, $reliever, $remarks, $data,$relieverlog);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }

            return Redirect()->to('waiting-list')->with('msg-success', 'Leave Successfully Updated');
        } catch
        (\Exception $e) {
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }


    }

    public
    function cancelLeave($id)
    {
        try {

            $data = array('LEAVE_STATUS' => '4');
            LeaveApplication::where('id', $id)->update($data);

            return Redirect()->to('waiting-list')->with('msg-success', 'Leave application canceled.');
        } catch (\Exception $e) {
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public
    function editEmployeeLeave($id)
    {
        $employeeLeaveData = EmployeeLeave::where('id', $id);

        $future = array(
            '' => '--Please Select--',
            '1' => 'Yes',
            '2' => 'No',
        );

        if ($employeeLeaveData->count() > 0) {
            $employeeLeave = $employeeLeaveData->first();

            return view('Leave::edit_leave_count', compact('employeeLeave', 'future'));
        } else {
            return Redirect()->back()->with('msg-error', 'Employee information not found');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public
    function updateEmployeeLeave(Request $request, $id)
    {
        $inputs = $request->all();
        $validator = \Validator::make($inputs, array(
            'LEAVE_TYPE_ID' => 'required',
            'leave_balance' => 'required|int',
            'leave_taken' => 'required|int',
            'last_forwarded_leave' => 'required|int'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array(
            'leave_balance' => $request->leave_balance,
            'leave_taken' => $request->leave_taken,
            'last_forwarded_leave' => $request->last_forwarded_leave,
            'future_apply' => $request->future_apply,
            'updated_by' => auth()->user()->id,
            'updated_at' => carbon::now()
        );
        //dd($data);

        $leaveBalance = EmployeeLeave::where('id', $id)->first();

        EmployeeLeave::where('id', $id)->update($data);

        return Redirect()->to('view-employee-leave/' . $leaveBalance->employee_id)->with('msg-success', 'Leave Balance Successfully Updated');
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public
    function viewEmployeeLeave($employee_id)
    {
        $employeeLeaveData = EmployeeLeave::where('employee_id', $employee_id)
            ->where('leave_balance', '!=', null);

        if ($employeeLeaveData->count() > 0) {
            $employeeLeaves = $employeeLeaveData->get();
            //dd($employeeLeaves);
            return view('Leave::view_leave_balance', compact('employeeLeaves'));
        } else {
            return Redirect()->back()->with('msg-error', 'Employee information not found');
        }
    }


    /**
     * Show the form for check Employee Leave Conditions
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkLeaveBalance(Request $request)
    {
        $employee_id = auth()->user()->employee_id;
        $leaveTypeInfo = LeaveType::findOrFail($request->leave_type_id);
        $leaveInfo = EmployeeLeave::where('leave_type_id', $request->leave_type_id)
            ->where('employee_id', $employee_id);

        if ($leaveInfo->count() > 0) {
            $employee_leave_info = $leaveInfo->first();

            if ($employee_leave_info->leave_balance > 0) {
                $leave_taken = $employee_leave_info->leave_taken;
                $data['status'] = 'success';
                //$data['current_balance'] = $employee_leave_info->leave_balance;
                $data['current_balance'] = $employee_leave_info->last_forwarded_leave;
                $data['future_apply'] = $employee_leave_info->future_apply;
                $data['leave_taken'] = ($leave_taken > 0) ? $leave_taken : 0;

            } else {
                $data['status'] = 'error';
                $data['message'] = 'You have no ' . $leaveTypeInfo->leave_type . ' balance.';
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'No leave found for this employee.';
        }
        return response()->json($data);
    }

    public
    function checkEmployeeLeaveConditions(Request $request)
    {


        $employee_id = auth()->user()->employee_id;
        $total_days = 0;

        if ($request->total_days > 0)
            $total_days = $request->total_days;

        $leaveTypeInfo = LeaveType::findOrFail($request->leave_type_id);

        $leaveInfo = EmployeeLeave::where('leave_type_id', $request->leave_type_id)->where('employee_id', $employee_id);

        if ($leaveInfo->count() > 0) {
            $employee_leave_info = $leaveInfo->first();

            if ($employee_leave_info->leave_balance > 0) {
                $remaining_balance = ($employee_leave_info->leave_balance - $total_days);

                $data['status'] = 'success';
                /* $data['current_balance'] = $employee_leave_info->leave_balance;*/
                $data['current_balance'] = $employee_leave_info->last_forwarded_leave;
                $data['remaining_balance'] = ($remaining_balance > 0) ? $remaining_balance : 0;

                if ($total_days > $leaveTypeInfo->max_taken_at_a_time) {
                    $data['total_days_status'] = 'exceeds';
                    $data['message'] = 'You exceeds the at a time maximum leave limit.';
                } else {
                    $data['total_days_status'] = 'ok';
                }
            } else {
                $data['status'] = 'error';
                $data['message'] = 'You have no ' . $leaveTypeInfo->leave_type . ' balance.';
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'No leave found for this employee.';
        }
        return response()->json($data);
    }

    public
    function leaveForm($id)
    {
        //$leave_id=$id;
        $src = "http://192.168.200.132:8080/jasperserver/flow.html?_flowId=viewReportFlow&_flowId=viewReportFlow&ParentFolderUri=%2FHRM_Report&reportUnit=%2FHRM_Report%2FEmployee_Leave_Application_Form&decorate=no&j_username=hr_report&j_password=hr_report&standAlone=true&leaveId=$id";
        return view('Leave::leave_form', compact('src'));
    }

    public
    function viewLeaveLogInformation($id)
    {
        $leave_id = LeaveApplicationLog::where('leave_id', $id)->orderby('updated_at')->get();
        $leave_applied = LeaveApplication::where('id', $id)->first();
        $leave_attachment = LeaveAttachment::where('leave_id', $id)->first();
        return view('Leave::leave_application_log_info', compact('leave_id', 'leave_applied', 'leave_attachment'));
    }


}
