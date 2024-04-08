<?php
// app/Observers/LeaveApplicationObserver.php

namespace App\Observers;

use App\Modules\Leave\Models\LeaveApplication;
use App\Modules\Leave\Models\LeaveApplicationDetails;
use App\Modules\Attendance\Models\EmployeeFinalAttendance;
use App\Modules\Leave\Models\EmployeeLeave;
use Carbon\Carbon;

class LeaveApplicationObserver
{
    public function updating(LeaveApplication $leaveApplication)
    {
        \Log::info('LeaveApplicationObserver-updating-' . 'Log written');
        if ($leaveApplication->leave_status == 3) {
            $noOfDays = Carbon::parse($leaveApplication->end_date)->diffInDays(Carbon::parse($leaveApplication->start_date));

            for ($aa = $noOfDays; $aa >= 0; $aa--) {
                LeaveApplicationDetails::create([
                    'employee_id' => $leaveApplication->employee_id,
                    'leave_type_id' => $leaveApplication->leave_type_id,
                    'date' => Carbon::parse($leaveApplication->start_date)->addDays($aa),
                    'leave_status' => $leaveApplication->leave_status,
                    'created_at' => now(),
                ]);

                if (Carbon::parse($leaveApplication->start_date)->lt(now())) {
                    EmployeeFinalAttendance::where([
                        'employee_id' => $leaveApplication->employee_id,
                        'attendance_date' => Carbon::parse($leaveApplication->start_date)->addDays($aa),
                    ])->update([
                        'remarks' => $this->getLeaveTypeName($leaveApplication->leave_type_id),
                    ]);
                }
            }

            EmployeeLeave::where([
                'employee_id' => $leaveApplication->employee_id,
                'leave_type_id' => $leaveApplication->leave_type_id,
            ])->update([
                'leave_taken' => optional($leaveApplication->leaveTaken)->leave_taken + $leaveApplication->total_days,
                'last_forwarded_leave' => optional($leaveApplication->lastForwardedLeave)->last_forwarded_leave - $leaveApplication->total_days,
            ]);
        }
    }

    private function getLeaveTypeName($leaveTypeId)
    {
        // You need to implement a function to get the leave type name based on the leave type ID
        // For example, you can have a LeaveType model and fetch the name using the ID.
        // Replace the following line with your actual implementation.

       // $leaveTypeName = LeaveType::where('leave_type',$leaveTypeId)->first();

        return $leaveTypeId;
    }
}
