<?php

namespace App\Http\Controllers;

use App\Modules\Attendance\Models\Attendance;
use App\Modules\Employee\Models\EmployeeDetails;
use Illuminate\Http\Request;

use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\BrDepartment\Models\BrDepartment;
use App\Modules\DepartmentUnit\Models\DepartmentUnit;
use App\Modules\Attendance\Models\EmployeeFinalAttendance;

use DB;


class CommonController extends Controller
{


    public function getBranchDivisions(Request $request) {
        $data = BrDivision::where('br_id', $request->branchID)->get();

        $option = '<option value="">--Please Select--</option>';


        foreach ($data as $key => $value) {
            $option .= '<option value='.$value->id.' >'.$value->br_name.'</option>';
        }
        return $option;
    }


    public function getBranchEmployees(Request $request) {
        $data = EmployeeDetails::where('branch_id', $request->empId)
            ->where('status', 1)
            ->get();

        $option = '<option value="">--Please Select--</option>';


        foreach ($data as $key => $value) {
            $option .= '<option value='.$value->employee_id.' >'.$value->employee_name.'</option>';
        }
        return $option;
    }

    public function getBranchDivisionDepartments(Request $request) {
        $data = BrDepartment::where('br_id', $request->branchID)
        ->where('div_id', $request->divisionID)
        ->get();

        $option = '<option value="">--Please Select--</option>';


        foreach ($data as $key => $value) {
            $option .= '<option value='.$value->id.' >'.$value->dept_name.'</option>';
        }
        return $option;
    }

    public function getBranchDivisionDepartmentUnits(Request $request) {
        $data = DepartmentUnit::where('branch_id','=',$request->branchID)
        ->where('division_id','=',$request->divisionID)
        ->where('department_id','=',$request->departmentID)
        ->get();

        $option = '<option value="">--Please Select--</option>';


        foreach ($data as $key => $value) {
            $option .= '<option value='.$value->id.' >'.$value->unit_name.'</option>';
        }
        return $option;
    }

   /* public function getEmployeeAttendaceInfo() {
        try {
            //$from = '2021-01-01';
            $from = date('Y-m-d');
            $date = date('Y-m-d');
            //$date = '2020-07-09';

            $table_name = 'device_data';

            // $todays_attaend_data = \DB::connection('attendance_mysql')->table($table_name)->whereDate('date', $date)->where('is_retrive', '0');
            $todays_attaend_data = \DB::connection('attendance_mysql')->table($table_name)->whereBetween('date', [$from, $date])->where('is_retrive', '0')->take(10);
            if($todays_attaend_data->count() > 0) {
                $todays_attaendances = $todays_attaend_data->get();

                foreach ($todays_attaendances as $todays_attaendance) {
                    $attendance_date = convertOracleDate($todays_attaendance->date);
                    $created_at = convertOracleDateTime(date('Y-m-d H:i:s'));

                    $attendanceInfo['employee_id'] = $todays_attaendance->barcode;
                    $attendanceInfo['attendance_date'] = convertOracleDate($todays_attaendance->date);
                    $attendanceInfo['in_time'] = $todays_attaendance->time_in;
                    $attendanceInfo['node_id'] = $todays_attaendance->nodeid;
                    $attendanceInfo['location'] = $todays_attaendance->location;
                    
                    // $attendanceInfo['created_at'] = convertOracleDateTime(date('Y-m-d H:i:s'));

                    // echo '<pre>';
                    // print_r($attendanceInfo);
                    // echo '</pre>';
                    // exit();

                    // $sql = "INSERT INTO EMPLOYEE_ATTAENDANCES (EMPLOYEE_ID, ATTENDANCE_DATE, IN_TIME, NODE_ID, LOCATION, CREATED_AT) VALUES ('".$todays_attaendance->barcode."', to_date('".$attendance_date."','dd-mm-yy'), '".$todays_attaendance->time_in."', '".$todays_attaendance->nodeid."', '".$todays_attaendance->location."', to_date('".$created_at."','dd-mm-yy hh24:mi:ss'))";

                    // $attendance = DB::table('employee_attaendances')->query($attendanceInfo);
                    
                    // $attendance = Attendance::create($attendanceInfo);
                    
                    if(Attendance::create($attendanceInfo)) {
                        $deviceData['is_retrive'] = '1';

                        $deviceInfo = \DB::connection('attendance_mysql')
                                        ->table($table_name)
                                        ->where('id', $todays_attaendance->id)
                                        ->update($deviceData);
                        echo 'new attendance found.';
                        // \Log::error('Attendance updated.');
                    } else {
                        \Log::error('Attendance not updated.');
                    }
                }
            } else {
                echo 'No new attendance info found.';
            }
        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            echo $e->getMessage();
        }
    }*/

    

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function common(Request $request)
    {
        return view("Report::common");
    }
}
