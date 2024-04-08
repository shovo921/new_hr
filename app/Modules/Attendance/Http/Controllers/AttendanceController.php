<?php

namespace App\Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Attendance\Models\Attendance;
use App\Modules\Attendance\Models\ManualAttendance;
use App\Modules\Attendance\Models\TodayAttendance;
use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\EmployeePosting;
use Illuminate\Http\Request;

use App\Modules\Attendance\Models\EmployeeFinalAttendance;
use App\Modules\Employee\Models\EmployeeDetails;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use PDO;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $_SESSION['MenuActive'] = 'attendance';
    }

    /**
     * @param $employee_id
     * @param $from_date
     * @param $to_date
     * @return array
     */
    public function archiveAttendance($employee_id, $from_date, $to_date): array
    {
        return DB::select("select EFA.*,nvl(D.SHORTCODE,D.DESIGNATION) AS DESIGNATION, ED.EMPLOYEE_NAME,B.BRANCH_NAME
                        from EMP_FINAL_ATTENDANCE EFA,
                        EMPLOYEE_DETAILS ED,
                        DESIGNATION D,BRANCH B
                        where EFA.EMPLOYEE_ID = ED.EMPLOYEE_ID
                        AND ED.DESIGNATION_ID = D.ID
                        AND B.ID = ED.BRANCH_ID
                        AND ED.STATUS = 1
                        AND ED.EMPLOYEE_ID in '$employee_id'
                        AND TO_DATE(EFA.ATTENDANCE_DATE, 'DD-MM-YY') between TO_DATE('$from_date','DD-MM-YY') and TO_DATE('$to_date','DD-MM-YY')
                        order by TO_DATE(EFA.ATTENDANCE_DATE, 'DD-MM-YY') DESC
                        ");
    }

    /**
     * @param $employee_id
     * @param $branch_id
     * @param $to_date
     * @return array
     */
    public function todayAttendances($employee_id, $branch_id, $to_date): array
    {
        return DB::select("select ED.EMPLOYEE_ID,
                    nvl(ATTENDANCE_DATE, '$to_date')                   as ATTENDANCE_DATE,
                    NVL(MIN(EA.IN_TIME),NVL(FXN_EMP_MANUAL_LOG_IN_TIME(TO_CHAR(TO_DATE('$to_date','DD-Mon-YYYY'),'DD-Mon-YYYY'),ED.EMPLOYEE_ID),FXN_EMP_ACTIVITY_LOG_IN_TIME('$to_date',ED.EMPLOYEE_ID)))as IN_TIME,
                    CASE WHEN NVL(MIN(EA.IN_TIME),FXN_EMP_ACTIVITY_LOG_IN_TIME('$to_date',ED.EMPLOYEE_ID)) > '10:00:00' THEN 'LATE IN' END                           as LATE_IN,
                    FXN_GET_ATTENDANCE_GATE(ED.EMPLOYEE_ID, MIN(EA.IN_TIME),
                    '$to_date')                as LOCATION,

    LEAVE_STATUS_DATE(ED.EMPLOYEE_ID,TO_DATE('$to_date','DD-Mon-YYYY')) as LEAVE_STATUS,
      FXN_ATTENDANCE_REMARKS(ED.EMPLOYEE_ID, '$to_date') as REMARKS,
       FXN_GET_DESIGNATION_ST_NAME(ED.DESIGNATION_ID)                                      AS DESIGNATION,
       ED.EMPLOYEE_NAME                                                                    as EMPLOYEE_NAME,
      FXN_EMP_ATTENDANCE_VERIFY_TYPE('$to_date',ED.EMPLOYEE_ID)                                                                    as VERIFY_TYPE,
       ED.PHONE_NO                                                                         as PHONE_NO,
       PAD_HRMS.FXN_GET_BRANCH_NAME(ED.BRANCH_ID)                                          as branch_name
        from EMPLOYEE_DETAILS ED
         LEFT join
        EMPLOYEE_ATTAENDANCES EA on ED.EMPLOYEE_ID = EA.EMPLOYEE_ID
         and EA.ATTENDANCE_DATE = '$to_date'
        WHERE ED.STATUS = 1
        AND ED.EMPLOYEE_ID in (Case when '$employee_id' is null then (select EMPLOYEE_ID from EMPLOYEE_DETAILS ED1 where ED1.EMPLOYEE_ID = ED.EMPLOYEE_ID) else '$employee_id' END)
        -- AND ED.BRANCH_ID = '$branch_id'
        AND ED.BRANCH_ID in (Case when '$branch_id' is null then (select nvl(BRANCH_ID,1) from EMPLOYEE_DETAILS ED1 where ED1.EMPLOYEE_ID = ED.EMPLOYEE_ID) else '$branch_id' END)
        group by ED.EMPLOYEE_ID, EA.ATTENDANCE_DATE, ED.BRANCH_ID, ED.DESIGNATION_ID, ED.EMPLOYEE_NAME, ED.PHONE_NO
        ORDER BY EMP_SENIORITY_ORDER(ED.EMPLOYEE_ID),FXN_ATTENDANCE_REMARKS(ED.EMPLOYEE_ID, '$to_date') DESC,ED.BRANCH_ID ASC");
    }


    /**
     * Display the module all employee Attendance
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $_SESSION['SubMenuActive'] = 'employee-attendance';
        $employee_id = auth()->user()->employee_id;
        $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');
        $allBranches = Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
            ->pluck('branch_name', 'branch');
        $branchList = $this->makeDD($allBranches);

        $employeeList = $this->makeDD($allEmployees);

        if (!$request->employee_id) {
            if ($employee_id == 'hradmin' || $employee_id == 'hrexecutive') {
                $employee = EmployeeDetails::first();
                $employee_id = $employee->employee_id;
            } else {
                $employee_id = auth()->user()->employee_id;
            }
        } else {
            $employee_id = $request->employee_id;
        }

        if (auth()->user()->role_id == '21') {
            if (!$request->from_date) {
                $sql = "select trunc(sysdate, 'MM') firstday from dual";
                $date1 = DB::select($sql);
                $from_date = date('d-m-Y', strtotime($date1[0]->firstday));

            } else {
                $from_date = date('d-m-Y', strtotime($request->from_date));
            }


            if (!$request->to_date) {
                $sql = "select trunc(sysdate) lastday from dual";
                $date2 = DB::select($sql);
                $to_date = date('d-m-Y', strtotime($date2[0]->lastday));
            } else {
                $to_date = date('d-m-Y', strtotime($request->to_date));
            }

            $dept_head = EmployeePosting::where('employee_id', auth()->user()->employee_id)->first();
            //dd($dept_head);
            if (!empty($request->employee_id)) {
                $attendanceInfo = $this->archiveAttendance($request->employee_id, $from_date, $to_date);
            } else {
                if ($dept_head->dept_head == 2) {

                    $attendanceInfo = $this->archiveAttendance($employee_id, $from_date, $to_date);
                } else {
                    $attendanceInfo = DB::select("select EFA.*,nvl(D.SHORTCODE,D.DESIGNATION) AS DESIGNATION, ED.EMPLOYEE_NAME,B.BRANCH_NAME
                        from EMP_FINAL_ATTENDANCE EFA,
                        EMPLOYEE_DETAILS ED,
                        DESIGNATION D,BRANCH B
                        where EFA.EMPLOYEE_ID = ED.EMPLOYEE_ID
                        AND ED.DESIGNATION_ID = D.ID
                        AND B.ID = ED.BRANCH_ID
                        AND ED.STATUS = 1
                        AND ED.EMPLOYEE_ID in (select EMPLOYEE_ID from EMPLOYEE_POSTING EP where EP.BR_DEPARTMENT_ID = '$dept_head->br_department_id')
                        AND TO_DATE(EFA.ATTENDANCE_DATE, 'DD-MM-YY') between TO_DATE('$from_date','DD-MM-YY') and TO_DATE('$to_date','DD-MM-YY')
                        order by EMP_SENIORITY_ORDER(ED.EMPLOYEE_ID),TO_DATE(EFA.ATTENDANCE_DATE, 'DD-MM-YY') DESC
                        ");
                }
            }

        } elseif (auth()->user()->role_id == "2") {
            if (!$request->from_date || !$request->to_date) {
                $date = Carbon::now()->subDay();
                //dd($date);
                $to_date = date('d-m-Y', strtotime($date));
                $from_date = date('d-m-Y', strtotime($date));

            } else {
                $to_date = date('d-m-Y', strtotime($request->to_date));
                $from_date = date('d-m-Y', strtotime($request->from_date));
            }
            $branch_id = auth()->user()->branch_id;

            $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('branch_id', $branch_id)
                ->where('status', 1)
                ->pluck('employee_name', 'employee_id');
            $employeeList = $this->makeDD($allEmployees);
            $allBranches = Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->where('id', $branch_id)
                ->pluck('branch_name', 'branch');
            $branchList = $this->makeDD($allBranches);
            $sql = "select EFA.*,nvl(D.SHORTCODE,D.DESIGNATION) AS DESIGNATION, ED.EMPLOYEE_NAME,B.BRANCH_NAME
                        from EMP_FINAL_ATTENDANCE EFA,
                        EMPLOYEE_DETAILS ED,
                        DESIGNATION D,BRANCH B
                        where EFA.EMPLOYEE_ID = ED.EMPLOYEE_ID
                        AND ED.DESIGNATION_ID = D.ID
                        AND B.ID = ED.BRANCH_ID
                        AND ED.STATUS = 1
                        AND ED.EMPLOYEE_ID in (Case when '$request->employee_id' is null then (select EMPLOYEE_ID from EMPLOYEE_DETAILS ED1 where ED1.EMPLOYEE_ID = ED.EMPLOYEE_ID and ED1.BRANCH_ID='$branch_id') else '$employee_id' END)
                        AND TO_DATE(EFA.ATTENDANCE_DATE, 'DD-MM-YY') between TO_DATE('$from_date','DD-MM-YY') and TO_DATE('$to_date','DD-MM-YY')
                        order by D.SENIORITY_ORDER,TO_DATE(EFA.ATTENDANCE_DATE, 'DD-MM-YY') DESC";
            $attendanceInfo = DB::select($sql);
            //$attendanceInfo = EmployeeFinalAttendance::paginate(30);
            //dd($employeeList);
        } else {
            if (!$request->from_date || !$request->to_date) {
                $date = Carbon::now()->subDay();
                $to_date = date('d-m-Y', strtotime($date));
                $from_date = date('d-m-Y', strtotime($date));
                //dd($to_date,$from_date);

            } else {
                $to_date = date('d-m-Y', strtotime($request->to_date));
                $from_date = date('d-m-Y', strtotime($request->from_date));
            }
            $sql = "select EFA.*,nvl(D.SHORTCODE,D.DESIGNATION) AS DESIGNATION, ED.EMPLOYEE_NAME,B.BRANCH_NAME
                        from EMP_FINAL_ATTENDANCE EFA,
                        EMPLOYEE_DETAILS ED,
                        DESIGNATION D,BRANCH B
                        where EFA.EMPLOYEE_ID = ED.EMPLOYEE_ID
                        AND ED.DESIGNATION_ID = D.ID
                        AND B.ID = ED.BRANCH_ID
                        AND ED.STATUS = 1
                        AND ED.EMPLOYEE_ID in (Case when '$request->employee_id' is null then (select EMPLOYEE_ID from EMPLOYEE_DETAILS ED1 where ED1.EMPLOYEE_ID = ED.EMPLOYEE_ID) else '$employee_id' END)
                        AND B.ID in (Case when '$request->branch' is null then (select nvl(BRANCH_ID,1) from EMPLOYEE_DETAILS ED1 where ED1.EMPLOYEE_ID = ED.EMPLOYEE_ID) else '$request->branch' END)
                        AND TO_DATE(EFA.ATTENDANCE_DATE, 'DD-MM-YY') between TO_DATE('$from_date','DD-MM-YY') and TO_DATE('$to_date','DD-MM-YY')
                        order by EMP_SENIORITY_ORDER(ED.EMPLOYEE_ID),TO_DATE(EFA.ATTENDANCE_DATE, 'DD-MM-YY') DESC";
            $attendanceInfo = DB::select($sql);
        }

        return view("Attendance::index", compact('attendanceInfo', 'employeeList', 'branchList'));
    }

    /**
     * Display the module all employee Today Attendance
     *
     * @return \Illuminate\Http\Response
     */
    public function todayAttendance(Request $request)
    {
        $_SESSION['SubMenuActive'] = 'employee-attendance';
        $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->orderby(DB::raw('EMP_SENIORITY_ORDER(employee_id)'))
            ->pluck('employee_name', 'employee_id');
        $allBranches = Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
            ->pluck('branch_name', 'branch');
        $branchList = $this->makeDD($allBranches);
        $employeeList = $this->makeDD($allEmployees);
        $date = Carbon::now();

        $to_date = date('d-M-Y', strtotime($date));

        if (auth()->user()->role_id == "2") {
            $branch_id = auth()->user()->branch_id;
            $allEmployees = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('branch_id', $branch_id)
                ->where('status', 1)
                ->orderby(DB::raw('EMP_SENIORITY_ORDER(employee_id)'))
                ->pluck('employee_name', 'employee_id');
            $employeeList = $this->makeDD($allEmployees);
            $allBranches = Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->where('id', $branch_id)
                ->pluck('branch_name', 'branch');
            $branchList = $this->makeDD($allBranches);

            $attendanceInfo = $this->todayAttendances($request->employee_id, $branch_id, $to_date);
        } elseif (auth()->user()->role_id == "21") {
            $dept_head = EmployeePosting::where('employee_id', auth()->user()->employee_id)->first();
            $allEmployees = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
                ->join('employee_posting as ep', 'employee_details.employee_id', '=', 'ep.employee_id')
                ->where('ep.br_department_id', $dept_head->br_department_id)
                ->where('employee_details.status', 1)
                ->orderby(DB::raw('EMP_SENIORITY_ORDER(employee_id)'))
                ->pluck('employee_name', 'employee_id');
            $employeeList = $this->makeDD($allEmployees);
            $allBranches = Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->where('id', $dept_head->branch_id)
                ->pluck('branch_name', 'branch');
            $branchList = $this->makeDD($allBranches);

            if (!empty($request->employee_id)) {
                $attendanceInfo = $this->todayAttendances($request->employee_id, $request->branch, $to_date);
            } else {
                if ($dept_head->dept_head == 2) {
                    $attendanceInfo = $this->todayAttendances(auth()->user()->employee_id, auth()->user()->branch_id, $to_date);
                } else {
                    $attendanceInfo = DB::select("select ED.EMPLOYEE_ID,
                    nvl(ATTENDANCE_DATE, '$to_date')                   as ATTENDANCE_DATE,
                    NVL(MIN(EA.IN_TIME),NVL(FXN_EMP_MANUAL_LOG_IN_TIME(TO_CHAR(TO_DATE('$to_date','DD-Mon-YYYY'),'DD-Mon-YYYY'),ED.EMPLOYEE_ID),FXN_EMP_ACTIVITY_LOG_IN_TIME('$to_date',ED.EMPLOYEE_ID)))as IN_TIME,
                    CASE WHEN NVL(MIN(EA.IN_TIME),FXN_EMP_ACTIVITY_LOG_IN_TIME('$to_date',ED.EMPLOYEE_ID)) > '10:00:00' THEN 'LATE IN' END                           as LATE_IN,
                    FXN_GET_ATTENDANCE_GATE(ED.EMPLOYEE_ID, MIN(EA.IN_TIME),
                    '$to_date')                as LOCATION,

                    LEAVE_STATUS_DATE(ED.EMPLOYEE_ID,TO_DATE('$to_date','DD-Mon-YYYY')) as LEAVE_STATUS,
                      FXN_ATTENDANCE_REMARKS(ED.EMPLOYEE_ID, '$to_date') as REMARKS,
                       FXN_GET_DESIGNATION_ST_NAME(ED.DESIGNATION_ID)                                      AS DESIGNATION,
                       ED.EMPLOYEE_NAME                                                                    as EMPLOYEE_NAME,
                      FXN_EMP_ATTENDANCE_VERIFY_TYPE('$to_date',ED.EMPLOYEE_ID)                                                                    as VERIFY_TYPE,
                       ED.PHONE_NO                                                                         as PHONE_NO,
                       PAD_HRMS.FXN_GET_BRANCH_NAME(ED.BRANCH_ID)                                          as branch_name
                        from EMPLOYEE_DETAILS ED
                         LEFT join
                        EMPLOYEE_ATTAENDANCES EA on ED.EMPLOYEE_ID = EA.EMPLOYEE_ID
                         and EA.ATTENDANCE_DATE = '$to_date'
                        WHERE ED.STATUS = 1
                        AND ED.EMPLOYEE_ID in (select EMPLOYEE_ID from EMPLOYEE_POSTING EP where EP.BR_DEPARTMENT_ID = '$dept_head->br_department_id')
                        group by ED.EMPLOYEE_ID, EA.ATTENDANCE_DATE, ED.BRANCH_ID, ED.DESIGNATION_ID, ED.EMPLOYEE_NAME, ED.PHONE_NO
                        ORDER BY EMP_SENIORITY_ORDER(ED.EMPLOYEE_ID),FXN_ATTENDANCE_REMARKS(ED.EMPLOYEE_ID, '$to_date') DESC,ED.BRANCH_ID ASC");
                      }
                    }


        } else {
            $attendanceInfo = $this->todayAttendances($request->employee_id, $request->branch, $to_date);
        }


        return view("Attendance::today", compact('attendanceInfo', 'employeeList', 'branchList'));
    }

    /**
     * Display the module all employee Attendance filter
     *
     * @return \Illuminate\Http\Response
     */
    private function __allAttendanceFilter($request)
    {
        $conn = connectOracle();

        $branch = null;
        $employee_id = null;
        /*        $dateFrom = date('d-M-Y'); //'08-Jun-2021';
                $dateTo = date('d-M-Y'); ///'08-Jun-2021';*/

        $dateFrom = '01-Dec-2021';
        $dateTo = '05-Dec-2022';


        if ($request->filled('branch_id')) {
            $branch = $request->branch_id;
        }
        if ($request->filled('employee_id')) {
            $employee_id = $request->employee_id;
        }

        if ($request->filled('from_date')) {
            $dateFrom = $request->from_date;
        }
        if ($request->filled('to_date')) {
            $dateTo = $request->to_date;
        }

        $sql = 'BEGIN PAD_HRMS.SP_ATTENDANCE_REPORT(:pbranch_id, :pemp_id,:pdt_from,:pdt_to, :OUTPUT_CUR); END;';

        //Statement does not change
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':pbranch_id', $branch, 10);
        oci_bind_by_name($stmt, ':pemp_id', $employee_id, 20);
        oci_bind_by_name($stmt, ':pdt_from', $dateFrom, 25);
        oci_bind_by_name($stmt, ':pdt_to', $dateTo, 25);

        //But BEFORE statement, Create your cursor
        $cursor = oci_new_cursor($conn);

        // On your code add the latest parameter to bind the cursor resource to the Oracle argument
        oci_bind_by_name($stmt, ":OUTPUT_CUR", $cursor, -1, OCI_B_CURSOR);

        // Execute the statement as in your first try
        oci_execute($stmt);

        // and now, execute the cursor
        oci_execute($cursor);


        $allAttendances = [];
        // Use OCIFetchinto in the same way as you would with SELECT
        while ($data = oci_fetch_assoc($cursor)) {
            array_push($allAttendances, $data);
        }

        return collect($allAttendances);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $branch = EmployeeDetails::select('branch_id')->where('employee_id', auth()->user()->employee_id)->first();

        if (auth()->user()->role_id == "1" || auth()->user()->role_id == "3") {
            $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->pluck('employee_name', 'employee_id');
            $employeeList = $this->makeDD($employeeData);
        } else {
            $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->where('branch_id', '=', $branch->branch_id)
                ->pluck('employee_name', 'employee_id');
            $employeeList = $this->makeDD($employeeData);
        }


        return view('Attendance::create', compact('employeeList'));
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
            'attendance_date' => 'required',
            'remarks' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }
        $inputs['attendance_date'] = date('d-M-Y', strtotime($inputs['attendance_date']));
        $current_date = Carbon::now();
        $inputs['modify_by'] = auth()->user()->employee_id;
        $inputs['in_time'] = date('H:i:s', strtotime($request->in_time));
        $inputs['out_time'] = date('H:i:s', strtotime($request->out_time));
        $inputs['created_at'] = date('Y-m-d H:i:s', strtotime($current_date));
        //dd($inputs['modify_by']);

        //dd($inputs);

        $br = new ManualAttendance();
        $br->fill($inputs)->save();

        //dump($br->ID);


        return Redirect()->to('attendance')->with('msg_success', 'Attendance Successfully Added');
    }

}
