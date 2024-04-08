<?php

namespace App\Modules\LeaveRmBmZone\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Employee\Models\EmployeePosting;
use App\Modules\LeaveRmBmZone\Models\BrBom;
use App\Modules\LeaveRmBmZone\Models\Zone;
use Illuminate\Http\Request;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BrBomController extends Controller
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
		$_SESSION['SubMenuActive'] = 'br_bom';
        $data['Br_Bom_List']  = BrBom::all();
		return view('LeaveRmBmZone::BrBom/list',compact('data'));

	}

    public function createOrEdit($id)
    {
        $data['posting_employee'] = EmployeePosting::join('EMPLOYEE_DETAILS', 'EMPLOYEE_POSTING.EMPLOYEE_ID', '=', 'EMPLOYEE_DETAILS.EMPLOYEE_ID')
            ->select('EMPLOYEE_POSTING.*','EMPLOYEE_DETAILS.EMPLOYEE_NAME As name')
            ->where('EMPLOYEE_DETAILS.EMPLOYMENT_TYPE',1)
            ->pluck('name', 'id');
        $data['branch']=Branch::all()->pluck('branch_name','id');


        $employeeList =EmployeeDetails::select(\Illuminate\Support\Facades\DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->orderby(DB::raw('EMP_SENIORITY_ORDER(employee_id)'))
            ->pluck('employee_name', 'employee_id');

        if (empty($id))
        {

        }
        else{
//          $data['br_bom'] = empty($id) ? null : BrBom::findOrFail($id);
            $data['br_bom'] = BrBom::findOrFail($id);
        }

        return view('LeaveRmBmZone::BrBom/createOrUpdate', compact('data','employeeList'));
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
                'branch_id'=>$request->branch_id,
                'effective_date'=>$request->effective_date,
                'status'=>$request->status
            ];

            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $brbom= new BrBom();
            if (empty($request->id)) {
                $brbom->fill($data)->save();
                return Redirect()->back()->with('msg-success', 'Br/Bom Successfully Created');
            } else {

                $brbom->findOrFail($request->id)->update($data);
                return Redirect()->back()->with('msg-success', 'Br/Bom  Successfully Updated');
            }

        } catch (\Exception $e) {
            \Log::info('Zone-storeOrUpdate-' . $e->getMessage());
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
