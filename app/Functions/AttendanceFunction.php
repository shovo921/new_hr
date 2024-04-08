<?php

namespace App\Functions;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

/**
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Created on 11-Nov-2022
 *
 */
class AttendanceFunction extends Controller
{

    /**
     * @param $employee_id
     * @param $from_date
     * @param $to_date
     * @return array
     */
    public function archiveAttendance($employee_id, $from_date, $to_date): array
    {
        try {
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
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * @param $employee_id
     * @param $branch_id
     * @param $to_date
     * @return array
     */
    public function todayAttendances($employee_id, $branch_id, $to_date): array
    {
        try {
            return DB::select("select ED.EMPLOYEE_ID,
                    nvl(ATTENDANCE_DATE, '$to_date')                   as ATTENDANCE_DATE,
                    NVL(MIN(EA.IN_TIME),NVL(FXN_EMP_MANUAL_LOG_IN_TIME(TO_CHAR(TO_DATE('$to_date','DD-Mon-YYYY'),'DD-Mon-YYYY'),ED.EMPLOYEE_ID),FXN_EMP_ACTIVITY_LOG_IN_TIME('$to_date',ED.EMPLOYEE_ID)))as IN_TIME,
                    CASE WHEN NVL(MIN(EA.IN_TIME),FXN_EMP_ACTIVITY_LOG_IN_TIME('$to_date',ED.EMPLOYEE_ID)) > '09:00:00' THEN 'LATE IN' END                           as LATE_IN,
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
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


}