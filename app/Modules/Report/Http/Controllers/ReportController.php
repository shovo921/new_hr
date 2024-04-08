<?php
/**
 * This is for report
 * @category   Report Controller
 * @package    Report Module
 * @author     Jobayer Ahmed
 * @copyright  2021-2050 The PHP Group
 * @version    1.0
**/

namespace App\Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Designation\Models\Designation;
use DB;

class ReportController extends Controller
{
	public function __construct()
	{
		$_SESSION['MenuActive'] = 'report';
	}

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function allEmployee(Request $request)
    {
    	$_SESSION['SubMenuActive'] = 'all-employee';

        $designations = $this->makeDD(Designation::pluck('designation', 'id'));

    	$employeeList = $this->__filterEmployee($request);
    	
        return view("Report::all-employee", compact('employeeList', 'designations'));
    }

    private function __filterEmployee($request) {
        $employeeList = DB::table('employee_details')
                ->select('employee_details.employee_id', 'employee_details.employee_name', 'employee_details.personal_file_no', 'designation.designation', 'employee_details.father_name', 'employee_details.mother_name', 'employee_details.phone_no', 'employee_details.birth_date', 'employee_details.birth_place', 'employee_details.nationality', 'employee_details.nid', 'employee_details.passport_no', 'employee_details.marital_status', 'employee_details.spouse_name', 'employee_details.marriage_date', 'employee_details.religion', 'employee_details.blood_group', 'employee_details.tin', 'employee_details.joining_date', 'employee_details.appointment_date', 'employee_details.batch_no_for_mto', 'employee_details.staff_type', 'employee_details.par_info_division', 'employee_details.par_info_thana', 'employee_details.par_info_district', 'employee_details.par_info_address', 'employee_details.pre_info_division', 'employee_details.pre_info_district', 'employee_details.pre_info_thana', 'employee_details.pre_info_address', 'employee_details.emergency_contact_name', 'employee_details.emergency_contact_relation', 'employee_details.emergency_contact_mobile', 'employee_details.emergency_contact_name2', 'employee_details.emergency_contact_relation2', 'employee_details.emergency_contact_mobile2', 'employee_details.created_at', 'employment_types.employment_type')
                ->join('designation', 'employee_details.designation_id', '=', 'designation.id')
                ->join('employment_types', 'employee_details.employment_type', '=', 'employment_types.id');

        if ($request->filled('employee_id')) {
            $employeeList->where('employee_details.employee_id', $request->employee_id);
        }
        if ($request->filled('employee_name')) {
            $employeeList->where('employee_details.employee_name', 'like', '%' . $request->employee_name . '%');
        }
        if ($request->filled('designation_id')) {
            $employeeList->where('employee_details.designation_id', $request->designation_id);
        }
        if ($request->filled('file_no')) {
            $employeeList->where('employee_details.personal_file_no', $request->file_no);
        }

        return $employeeList->paginate(20);
    }

}
