<?php

namespace App\Modules\BrDepartment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\BrDepartment\Models\BrDepartment;
use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\Branch\Models\Branch;

class BrDepartmentController extends Controller
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
    	$_SESSION["SubMenuActive"] = "br-department";

    	$br_department = BrDepartment::get();

        return view("BrDepartment::index", compact('br_department'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branchList   = $this->makeDD(Branch::orderBy('branch_name')->pluck('branch_name', 'id'));//where('branch_id', 'not like', 'H%')
        $divisionList = $this->makeDD(BrDivision::where('br_status','1')->pluck('br_name', 'id'));

        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

    	return view('BrDepartment::create',compact('divisionList','branchList','status'));
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
    		'br_id'=>'required|int',
            'div_id'=>'required|int',
            'dept_name'=>'required',
    		'dept_details'=>'required',
    		'dept_status'=>'required|int'
    	));
        
    	if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

        

    	$br = new BrDepartment();
        $br->fill($inputs)->save();
        
        
    	return Redirect() -> to('br-department') -> with('msg_success', 'Department(Division) Successfully Created');
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
        $br_department = BrDepartment::findOrFail($id); 

        $branchList   = $this->makeDD(Branch::orderBy('branch_name')->pluck('branch_name', 'id'));//where('branch_id', 'not like', 'H%')
        $divisionList = $this->makeDD(BrDivision::where('br_status','1')->pluck('br_name', 'id'));
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

    	return view('BrDepartment::edit',compact('br_department','divisionList','branchList','status'));

    	
        
       
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
        $br_department = BrDepartment::findOrFail($id); 
    	$inputs = $request->all();

    	$validator = \Validator::make($inputs, array(
    		'br_id'=>'required|int',
            'div_id'=>'required|int',
            'dept_name'=>'required',
    		'dept_details'=>'required',
    		'dept_status'=>'required|int'
    	));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        //dd($inputs);
        
        $brDeptInfo["br_id"] = $request->br_id;
        $brDeptInfo["div_id"] = $request->div_id;
        $brDeptInfo["dept_name"] = $request->dept_name;
        $brDeptInfo["dept_details"] = $request->dept_details;
        $brDeptInfo["dept_status"] = $request->dept_status;

        BrDepartment::where('ID', $id)->update($brDeptInfo);

    	return Redirect() -> to('br-department') -> with('msg_success', 'Department(Division) Successfully Updated');
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
            BrDepartment::destroy($id);
            return Redirect() -> to('br-department') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('br-department') -> with('msg-error', "This item is already used.");
    	}
    }
}
