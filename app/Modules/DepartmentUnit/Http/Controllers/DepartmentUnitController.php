<?php

namespace App\Modules\DepartmentUnit\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Branch\Models\Branch;
use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\BrDepartment\Models\BrDepartment;
use App\Modules\DepartmentUnit\Models\DepartmentUnit;


class DepartmentUnitController extends Controller
{

    public function __construct(){
		$_SESSION["MenuActive"] = "settings";
	}
    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$_SESSION["SubMenuActive"] = "department-unit";

    	$departmentUnitList = DepartmentUnit::get();

        return view("DepartmentUnit::index", compact('departmentUnitList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branchList   = $this->makeDD(Branch::orderBy('branch_name')->pluck('branch_name', 'id')); //where('branch_id', 'not like', 'H%')
        $divisionList = $this->makeDD(BrDivision::where('br_status','1')->pluck('br_name', 'id'));
        $departmentList = $this->makeDD(BrDepartment::where('dept_status','1')->pluck('dept_name', 'id'));

       $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

    	return view('DepartmentUnit::create',compact('branchList', 'divisionList', 'departmentList', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$inputs = $request->all();
        
    	$validator = \Validator::make($inputs, array(
    		'branch_id'=>'required|int',
            'division_id'=>'required|int',
            'department_id'=>'required|int',
    		'unit_name'=>'required',
    		'status'=>'required|int'
    	));
        
    	if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$departmentUnit = new DepartmentUnit();
        $departmentUnit->fill($inputs)->save();
        
    	return Redirect() -> to('department-unit') -> with('msg-success', 'Department Unit Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$departmentUnit = DepartmentUnit::findOrFail($id);

        $branchList   = $this->makeDD(Branch::orderBy('branch_name')->pluck('branch_name', 'id')); //where('branch_id', 'not like', 'H%')
        $divisionList = $this->makeDD(BrDivision::where('br_status','1')->pluck('br_name', 'id'));
        $departmentList = $this->makeDD(BrDepartment::where('dept_status','1')->pluck('dept_name', 'id'));

        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );
        return view('DepartmentUnit::edit',compact('departmentUnit', 'branchList', 'divisionList', 'departmentList', 'status'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $departmentUnit = DepartmentUnit::findOrFail($id);
    	$inputs = $request->all();

    	$validator = \Validator::make($inputs, array(
            'branch_id'=>'required|int',
            'division_id'=>'required|int',
            'department_id'=>'required|int',
            'unit_name'=>'required',
            'status'=>'required|int'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $departmentUnitInfo["branch_id"] = $request->branch_id;
        $departmentUnitInfo["division_id"] = $request->division_id;
        $departmentUnitInfo["department_id"] = $request->department_id;
        $departmentUnitInfo["unit_name"] = $request->unit_name;
        $departmentUnitInfo["status"] = $request->status;

        DepartmentUnit::where('id', $id)->update($departmentUnitInfo);

    	return Redirect() -> to('department-unit') -> with('msg-success', 'Department Unit Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	try {
    		DepartmentUnit::destroy($id);
    		return Redirect() -> route('department-unit.index') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
    		return Redirect() -> route('department-unit.index') -> with('msg-error', "This item is already used.");
    	}
    }
}
