<?php

namespace App\Http\Controllers;

use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\JobDescription\Models\EmployeeJD;
use App\Modules\Leave\Models\LeaveApplication;
use App\Modules\Leave\Models\LeaveApplicationDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Log;


class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $colors = [];

    public function __construct()
    {
        $this->middleware('auth');
        $this->colors = ['#66CDAA', '#6495ED', '#FF69B4', '#D2B48C', '#E6E6FA'];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*public function index() {
        /*echo $subFromDate = date('F d, Y', strtotime('01-Jan-2021'));
        echo '<br>';
        echo $subToDate = date('F d, Y', strtotime('30-Jun-2021'));
        echo '<br>';

        $AC = '0112100140909';
        $maskingCharacter = '*';
            
        $masking_name = substr($AC, 0, 2) . str_repeat($maskingCharacter, strlen($AC) - 9) . substr($AC, -2);
        echo $masking_name.'_'.uniqid();
        exit;


            $total_employee = 0;
            $total_branch = 0;
            $total_attendance = 0;
            $total_absent = 0;

            //$total_employee = User::where('status', '1')->count();
            $total_employee = EmployeeDetails::where('prefix',null)->where('status', '1')->count();
            $total_male_Employee = EmployeeDetails::where('prefix',null)->where('gender','Male')->where('status', '1')->count();
            $total_female_Employee = EmployeeDetails::where('prefix',null)->where('gender','Female')->where('status', '1')->count();

            $total_casual_staff = EmployeeDetails::where('prefix','C')->where('status', '1')->count();
            $total_female_casual_staff = EmployeeDetails::where('prefix','C')->where('gender','Female')->where('status', '1')->count();
            $total_male_casual_staff = EmployeeDetails::where('prefix','C')->where('gender','Male')->where('status', '1')->count();

            $total_female_sales_staff =EmployeeDetails::where('prefix','R')->where('gender','Female')->where('status', '1')->count();
            $total_sales_staff =EmployeeDetails::where('prefix','R')->where('status', '1')->count();
            $total_male_sales_staff =EmployeeDetails::where('prefix','R')->where('gender','Male')->where('status', '1')->count();
            $employee = auth()->user();
            $total_branch = Branch::where('branch_id', 'not like', 'H%')->count();
            $employee_id =auth()->user()->employee_id;
            //dd($total_employee,$total_male_Employee,$total_female_Employee);
            if($employee_id == 'hradmin' || $employee_id =='hrexecutive'){
                $total_waitingList=LeaveApplication::whereNotIn('leave_status', [3,4])->count();
            }else{
                $total_waitingList=LeaveApplication::where('waiting_for',auth()->user()->employee_id)->whereNotIn('leave_status', [3,4])->count();
            }


            return view('home', compact('total_employee','total_male_Employee','total_female_Employee','total_casual_staff','total_female_casual_staff','total_male_casual_staff','total_sales_staff','total_female_sales_staff','total_male_sales_staff', 'total_branch','total_waitingList','employee', 'total_attendance', 'total_absent'));
        }*/


    public function index()
    {
        /*echo $subFromDate = date('F d, Y', strtotime('01-Jan-2021'));
        echo '<br>';
        echo $subToDate = date('F d, Y', strtotime('30-Jun-2021'));
        echo '<br>';

        $AC = '0112100140909';
        $maskingCharacter = '*';

        $masking_name = substr($AC, 0, 2) . str_repeat($maskingCharacter, strlen($AC) - 9) . substr($AC, -2);
        echo $masking_name.'_'.uniqid();
        exit;*/
        if ((auth()->user()->password_changed_at === null)) {
            $user = auth()->user();
            return view("User::index", compact('user'));
        } else {
            $total_employee = 0;
            $total_branch = 0;
            $total_attendance = 0;
            $total_absent = 0;

            //$total_employee = User::where('status', '1')->count();
            $total_employee = EmployeeDetails::where('prefix', null)->where('status', '1')->count();
            $total_male_Employee = EmployeeDetails::where('prefix', null)->where('gender', 'Male')->where('status', '1')->count();
            $total_female_Employee = EmployeeDetails::where('prefix', null)->where('gender', 'Female')->where('status', '1')->count();

            $total_casual_staff = EmployeeDetails::where('prefix', 'C')->where('status', '1')->count();
            $total_female_casual_staff = EmployeeDetails::where('prefix', 'C')->where('gender', 'Female')->where('status', '1')->count();
            $total_male_casual_staff = EmployeeDetails::where('prefix', 'C')->where('gender', 'Male')->where('status', '1')->count();

            $total_female_sales_staff = EmployeeDetails::where('prefix', 'R')->where('gender', 'Female')->where('status', '1')->count();
            $total_sales_staff = EmployeeDetails::where('prefix', 'R')->where('status', '1')->count();
            $total_male_sales_staff = EmployeeDetails::where('prefix', 'R')->where('gender', 'Male')->where('status', '1')->count();
            $employee = auth()->user();
            $total_branch = Branch::where('head_office', 2)->count();

            $today = date('Y-m-d', strtotime(Carbon::now()));
            $totalLeave = LeaveApplicationDetails::where('leave_date', $today)->count();
            $totalPresent = DB::select("select NVL(FXN_EMP_TODAY_ATTENDANCE_COUNT(),'Not Found') TotalPresent from DUAL");
            $employee_id = auth()->user()->employee_id;

            $jdInfo = ($employee_id == 'hradmin' || $employee_id == 'hrexecutive'||$employee_id == 'cbo' || $employee_id == 'md' || $employee_id == 'hrleaveofficer' || $employee_id == 'hrdeputyhead' || $employee_id == 'hrhead' || $employee_id == 'itadmin' ? null :
                (empty(EmployeeJD::where('employee_id', $employee_id)->first()) ? null
                    : EmployeeJD::where('employee_id', $employee_id)->where('status', 1)->first()));


           $today_attendance = DB::select("select NVL(FXN_EMP_TODAY_ATTENDANCE('$employee_id'),'Not Found') Todays_Attendance from DUAL");

            if ($employee_id == 'hradmin' || $employee_id == 'hrexecutive'||$employee_id == 'cbo' || $employee_id == 'md' || $employee_id == 'hrleaveofficer' || $employee_id == 'hrdeputyhead' || $employee_id == 'hrhead' || $employee_id == 'itadmin') {
                $total_waitingList = LeaveApplication::where('waiting_for', $employee_id)->whereNotIn('leave_status', [3, 4])->count();
                $totalJdApproval = EmployeeJD::where('approver_id', 'hradmin')->where('status', 2)->count();
                $jdApproveBrManager = null;
            } else {
                $total_waitingList = LeaveApplication::where('waiting_for', $employee_id)->whereNotIn('leave_status', [3, 4])->count();
                $totalJdApproval = (auth()->user()->employee_id == 'hradmin' ? EmployeeJD::count() :
                    EmployeeJD::where('employee_id', $employee_id)->count());
                $jdApproveBrManager = EmployeeJD::where('approver_id', $employee_id)->where('status', 2)->count();
            }



            return view('home', compact('total_employee','today_attendance','totalPresent', 'jdInfo', 'jdApproveBrManager', 'totalJdApproval', 'totalLeave',  'total_male_Employee', 'total_female_Employee', 'total_casual_staff', 'total_female_casual_staff', 'total_male_casual_staff', 'total_sales_staff', 'total_female_sales_staff', 'total_male_sales_staff', 'total_branch', 'total_waitingList', 'employee', 'total_attendance', 'total_absent'));
        }


    }

    private function __monthlyBarChart($data)
    {

        foreach ($data->groupBy('month') as $key => $value) {
            $labels[] = \DateTime::createFromFormat('!m', $key)->format('F');
        }
        $i = 0;
        foreach ($data->groupBy('category.name') as $category => $value) {
            $data = null;
            foreach ($value as $v) {
                $data[] = $v->total_order;
            }
            $datasets[] = [
                'label' => $category ?? null,
                'data' => $data ?? null,
                'backgroundColor' => $this->colors[$i++],
                'borderWidth' => 1
            ];
        }
        return $dataset = [
            'labels' => $labels ?? null,
            'datasets' => $datasets ?? null
        ];
    }

    private function __currentMonthBarChart()
    {

        $data = DailySell::with('category')->whereBetween('order_date', [date("Y-m-01"), Carbon::now()->format('Y-m-d')])->get();
        foreach ($data->groupBy('order_date') as $key => $value) {
            $labels[] = $key;
        }
        $i = 0;
        foreach ($data->groupBy('category.name') as $category => $value) {
            $data = null;
            foreach ($value as $v) {
                $data[] = $v->total_order;
            }
            $datasets[] = [
                'label' => $category ?? null,
                'data' => $data ?? null,
                'backgroundColor' => $this->colors[$i++],
                'borderWidth' => 1
            ];
        }
        return $dataset = [
            'labels' => $labels ?? null,
            'datasets' => $datasets ?? null
        ];
    }

    private function __monthlyPieChart($data)
    {
        $i = 0;
        foreach ($data as $key => $value) {
            $labels[] = $value->category->name;
            $d[] = $value->total_order;
            $colors[] = $this->colors[$i++];
        }

        $datasets[] = [
            'data' => $d ?? null,
            'backgroundColor' => $colors ?? null
        ];
        return $dataset = [
            'labels' => $labels ?? null,
            'datasets' => $datasets ?? null
        ];
    }


}
