<?php

namespace App\Modules\LeaveRmBmZone\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeePosting;
use App\Modules\LeaveRmBmZone\Models\BrBom;
use App\Modules\LeaveRmBmZone\Models\RmModel;
use App\Modules\LeaveRmBmZone\Models\Zone;
use Illuminate\Http\Request;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RMController extends Controller
{
	public function __construct(){
		$_SESSION["MenuActive"] = "transfer";
	}

	/**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
        $allEmployees = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->join('employee_posting as ep', 'ep.employee_id', '=', 'employee_details.employee_id')
            ->join('RM_LIST as bh', 'ep.id', '=', 'bh.posting_id')
            ->where('employee_details.status', 1)
            ->get();
//        dd($allEmployees);

		$_SESSION['SubMenuActive'] = 'Rm_List';
        $data['Rm_List']  = RmModel::all();
		return view('LeaveRmBmZone::Rm/list',compact('data'));

	}

    public function createOrEdit($id)
    {
        $data['posting_employee'] = EmployeePosting::join('EMPLOYEE_DETAILS', 'EMPLOYEE_POSTING.EMPLOYEE_ID', '=', 'EMPLOYEE_DETAILS.EMPLOYEE_ID')
            ->select('EMPLOYEE_POSTING.*','EMPLOYEE_DETAILS.EMPLOYEE_NAME As name')
            ->where('EMPLOYEE_DETAILS.EMPLOYMENT_TYPE',1)
            ->pluck('name', 'id');
        $data['branch']=Branch::all()->pluck('branch_name','id');
        $data['zone']=Zone::all()->where('status',1)->pluck('name','id');



        $employeeList =EmployeeDetails::select(\Illuminate\Support\Facades\DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->orderby(DB::raw('EMP_SENIORITY_ORDER(employee_id)'))
            ->pluck('employee_name', 'employee_id');
        if (empty($id))
        {
            $data['rm']= null;


        }
        else{
//          $data['br_bom'] = empty($id) ? null : BrBom::findOrFail($id);
            $data['rm'] = RmModel::findOrFail($id);
        }

        return view('LeaveRmBmZone::Rm/createOrUpdate', compact('data','employeeList'));
    }

    public function storeOrUpdate(Request $request)
    {

        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'posting_employee_id' => 'required',
                'branch_id' => 'required',
                'status' => 'required'
            ));
            $data=[
                'posting_id'=>$request->posting_employee_id,
                'branch_list'=>json_encode($request->branch_id),
                'effective_date'=>$request->effective_date,
                'zone'=>$request->zone_id,
                'status'=>$request->status
            ];

            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $Rm= new RmModel();
            if (empty($request->id)) {
                $Rm->fill($data)->save();
                return Redirect()->back()->with('msg-success', 'Rm Successfully Created');
            } else {

                $Rm->findOrFail($request->id)->update($data);
                return Redirect()->back()->with('msg-success', 'Rm Successfully Updated');
            }

        } catch (\Exception $e) {
            \Log::info('Rm-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function destroy($id): RedirectResponse
    {
        try {
            Zone::findOrFail($id)->delete();
            return Redirect()->back()->with('msg-success', 'Bill Type Successfully Deleted');

        } catch (\Exception $e) {
            \Log::info('BillsTypeController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }
}
