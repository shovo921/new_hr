<?php

namespace App\Modules\Resignation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Resignation\Models\Resignation;
use App\Modules\Resignation\Models\ResignationCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Modules\Branch\Models\Branch;
use App\Modules\Division\Models\Division;
use App\Modules\District\Models\District;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class ResignationController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "employee";
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $_SESSION["SubMenuActive"] = "resignation";
        $resignedEmpLists = Resignation::orderby('status', 'desc')->get();
        return view("Resignation::index", compact('resignedEmpLists'));
    }

    /**
     * Employee Resign List For Authorization
     * @return Application|Factory|View
     */
    public function authorizeList(){
        $_SESSION["SubMenuActive"] = "resignation-auth";
        $resignedEmpLists = Resignation::where('status',2)->get();
        return view("Resignation::authorize_resign", compact('resignedEmpLists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resign = null;
        $resignCategory = ResignationCategory::pluck('description', 'id');
        $employeeList = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->where('employee_details.status', 1)
            ->pluck('employee_name', 'employee_id');
        return view('Resignation::create', compact('resignCategory', 'employeeList', 'resign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $inputs = $request->all();

            $validator = \Validator::make($inputs, array(
                'employee_id' => 'required|numeric',
                'resign_cat_id' => 'required|numeric',
                'date_resign' => 'required',
                'release_date' => 'required'
            ));

            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }

            $date_resign = str_replace('/', '-', $inputs['date_resign']);
            $release_date = str_replace('/', '-', $inputs['release_date']);


            $resignEntry['employee_id'] = $inputs['employee_id'];
            $resignEntry['resign_cat_id'] = $inputs['resign_cat_id'];
            $resignEntry['remarks'] = $inputs['remarks'];
            $resignEntry['date_resign'] = date("d-m-Y", strtotime($date_resign));
            $resignEntry['release_date'] = date("d-m-Y", strtotime($release_date));
            $resignEntry['status'] = '2';
            $resignEntry['created_by'] = auth()->user()->id;

            $br = new Resignation();
            $br->fill($resignEntry)->save();

            return Redirect()->to('resign')->with('msg_success', 'Employee Resignation Successfully Created');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resign = Resignation::where('id', $id)->first();
        $resignCategory = ResignationCategory::pluck('description', 'id');
        $employeeList = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->where('employee_details.status', 1)
            ->pluck('employee_name', 'employee_id');
        return view('Resignation::edit', compact('resignCategory', 'employeeList', 'resign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $inputs = $request->all();

            $validator = \Validator::make($inputs, array(
                'resign_cat_id' => 'required|numeric',
                'date_resign' => 'required',
                'release_date' => 'required'
            ));

            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $date_resign = str_replace('/', '-', $inputs['date_resign']);
            $release_date = str_replace('/', '-', $inputs['release_date']);

            $resignEntry['remarks'] = $inputs['remarks'];
            $resignEntry['date_resign'] = date("d-m-Y", strtotime($date_resign));
            $resignEntry['release_date'] = date("d-m-Y", strtotime($release_date));
            $resignEntry['status'] = '2';
            $resignEntry['resign_cat_id'] = $inputs['resign_cat_id'];;
            $resignEntry['updated_by'] = auth()->user()->id;
            Resignation::where('ID', $id)->update($resignEntry);

            return Redirect()->to('/resign')->with('msg_success', 'Employee Resignation Successfully Updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Employee Resign Authorized Controller
     * @param $id
     * @return void
     * Status
     *  1 = Approve, 2 = New Entry, 3 = Cancel
     */
    public function authorizeResign($id)
    {
        try {
            $resign = Resignation::where('id', $id)->first();
            $resignEntry['status'] = '1';
            $resignEntry['updated_by'] = auth()->user()->id;
            $resignEntry['updated_at'] = carbon::now()->format('Y-m-d h:i:s');
            $empDetails['status'] = '2';

            $resign->where('id', $id)->update($resignEntry);
            EmployeeDetails::where('employee_id',$resign->employee_id)->update($empDetails);
            return Redirect()->to('resign-auth-list')->with('msg_success', 'Employee Resignation Successfully Authorized');

        } catch (\Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Employee Resign Cancel
     * @param $id
     * @return RedirectResponse|void
     * Status
     *  1 = Approve, 2 = New Entry, 3 = Cancel
     */
    public function cancelResign($id){
        try{
            $resign = Resignation::where('id', $id)->first();
            $resignEntry['status'] = '3';
            $resignEntry['updated_by'] = auth()->user()->id;
            $resignEntry['updated_at'] = carbon::now()->format('Y-m-d h:i:s');
            $resign->where('id', $id)->update($resignEntry);
            return Redirect()->to('resign-auth-list')->with('msg_success', 'Employee Resignation Successfully Canceled');
        }catch(\Exception $e){
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Resignation::destroy($id);
            return Redirect()->to('resign')->with('msg-success', 'Successfully Deleted.');
        } catch (\Exception $e) {
            return Redirect()->to('resign')->with('msg-error', "This item is already used.");
        }
    }

    public function getDistricts(Request $request)
    {
        $data = District::where([['division_id', '=', $request->division_id]])
            ->get();

        $option = "";
        foreach ($data as $key => $value) {
            $option .= '<option value=' . $value->id . ' >' . $value->name . '</option>';
        }
        return $option;
    }

    /**
     * Returns The basic information of the employee
     * @return mixed
     */
    public function getEmployeeBasicInfo(Request $request)
    {
        return EmployeeDetails::select('employee_name','designation_id', 'designation', 'branch_name')
            ->where('employee_id', $request->employeeId)->first();
    }
}
