<?php

namespace App\Console\Commands;

use App\Modules\Attendance\Models\Attendance;
use App\Modules\Attendance\Models\AttendanceTest;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;

class AttendanceCronJobTest extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AttendanceCronJobTest:AttendanceCronJobTest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cronjob is for Attendance data fetch from mysql DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            //echo('Heloo'); die;
            //$from = '2022-03-01';
            $from = date('Y-m-d');
            $date = date('Y-m-d');
            //$date = '2022-05-29';

            $table_name = 'device_data';



             //$todays_attaend_data = \DB::connection('attendance_mysql_test')->table($table_name)->whereDate('date', $date)->where('is_retrive', '0')->whereBetween('date', [$from, $date]);
            // $todays_attaend_data = \DB::connection('attendance_mysql_test')->table($table_name)->whereBetween('date', [$from, $date])->where('is_retrive', '0')->take(10);
            $todays_attaend_data = \DB::connection('attendance_mysql_test')->table($table_name)->where('is_retrive',0);

            //echo($todays_attaend_data);  exit();

            if ($todays_attaend_data->count() > 0) {
                $todays_attaendances = $todays_attaend_data->get();


                foreach ($todays_attaendances as $todays_attaendance) {
                    $attendance_date = convertOracleDate($todays_attaendance->date);
                    $created_at = convertOracleDateTime(date('Y-m-d H:i:s'));


                    $attendanceInfo['employee_id'] = $todays_attaendance->barcode;
                    $attendanceInfo['attendance_date'] = convertOracleDate($todays_attaendance->date);
                    $attendanceInfo['in_time'] = $todays_attaendance->time_in;
                    $attendanceInfo['node_id'] = $todays_attaendance->nodeid;
                    $attendanceInfo['location'] = $todays_attaendance->location;
                    $attendanceInfo['verify_type'] = $todays_attaendance->verify_type;

                    // $attendanceInfo['created_at'] = convertOracleDateTime(date('Y-m-d H:i:s'));

                     /*echo '<pre>';
                     print_r($attendanceInfo);
                     echo '</pre>';
                     exit();*/

                    // $sql = "INSERT INTO EMPLOYEE_ATTAENDANCES (EMPLOYEE_ID, ATTENDANCE_DATE, IN_TIME, NODE_ID, LOCATION, CREATED_AT) VALUES ('".$todays_attaendance->barcode."', to_date('".$attendance_date."','dd-mm-yy'), '".$todays_attaendance->time_in."', '".$todays_attaendance->nodeid."', '".$todays_attaendance->location."', to_date('".$created_at."','dd-mm-yy hh24:mi:ss'))";

                    // $attendance = DB::table('employee_attaendances')->query($attendanceInfo);

                     // Attendance::create($attendanceInfo);

                    if (Attendance::create($attendanceInfo)) {
                        $deviceData['is_retrive'] = '1';

                        $deviceInfo = \DB::connection('attendance_mysql_test')
                            ->table($table_name)
                            ->where('id', $todays_attaendance->id)
                            ->update($deviceData);

                        // \Log::error('Attendance updated.');
                    } else {
                        \Log::error('Attendance not updated.');
                    }

                }
            } else {
                echo 'No new attendance info found.';
            }
            //$success_data = \DB::connection('attendance_mysql_test')->table($table_name)->where('is_retrive',1)->whereBetween('date', [$from, $date]);
            $success_data = \DB::connection('attendance_mysql_test')->table($table_name)->where('is_retrive',1);
            echo 'Total Data successfully Added'. $success_data->count() .'Total Left in Device Data'.' '.$todays_attaend_data->count();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            echo $e->getMessage();
        }

    }

}
