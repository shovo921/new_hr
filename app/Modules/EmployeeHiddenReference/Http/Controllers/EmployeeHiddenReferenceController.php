<?php

namespace App\Modules\EmployeeHiddenReference\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\EmployeeHiddenReference\Models\EmployeeHiddenReference;
use App\Modules\Employee\Models\EmployeeDetails;

use DB;

class EmployeeHiddenReferenceController extends Controller
{
	 public function __construct(){
        $_SESSION["MenuActive"] = "employee";
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $_SESSION["SubMenuActive"] = "hiddenReference";
        
        $hiddenReferences = EmployeeHiddenReference::all();
        

        return view("EmployeeHiddenReference::index", compact('hiddenReferences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"),'employee_id')
                        ->where('status', 1)
                        ->pluck('employee_name', 'employee_id');

    	$employeeList = $this->makeDD($employeeData);

        return view('EmployeeHiddenReference::create',compact('employeeList'));
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
            'employee_id'=>'required',
            'ref_name'=>'required',
            'designation'=>'required'
        ));

        $inputs['created_at'] = date('Y-m-d H:i:s');
        $inputs['created_by'] = auth()->user()->employee_id;

        unset($inputs['_token']);

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $hiddenReference = new EmployeeHiddenReference();
        $hiddenReference->fill($inputs)->save();

        return Redirect() -> to('employee-hidden-reference') -> with('msg_success', 'Employee Hidden Reference Successfully Created');
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
        $hiddenReference = EmployeeHiddenReference::where('employee_id', $id)->first();
        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"),'employee_id')
                        ->where('status', 1)
                        ->pluck('employee_name', 'employee_id');

    	$employeeList = $this->makeDD($employeeData);

    	return view('EmployeeHiddenReference::edit',compact('hiddenReference', 'employeeList'));
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
    	//$hiddenReference = EmployeeHiddenReference::where('employee_id', $id)->first();

//dd($employee_id);
    	$inputs = $request->all();
    	
        $validator = \Validator::make($inputs, array(
            'employee_id'=>'required',
            'ref_name'=>'required',
            'designation'=>'required'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$hiddenInfo['employee_id'] = $inputs['employee_id'];
    	$hiddenInfo['ref_name'] = $inputs['ref_name'];
    	$hiddenInfo['designation'] = $inputs['designation'];
    	$hiddenInfo['organization'] = $inputs['organization'];
    	$hiddenInfo['mobile_no'] = $inputs['mobile_no'];
    	$hiddenInfo['address'] = $inputs['address'];

        //dd($hiddenInfo);


    	EmployeeHiddenReference::where('employee_id',$id)->update($hiddenInfo);




		return Redirect() -> to('employee-hidden-reference') -> with('msg_success', 'Employee Hidden Reference Successfully Updated.');
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
    		EmployeeHiddenReference::where('employee_id', $id)->delete();
    		return Redirect() -> route('employee-hidden-reference.index') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
    		return Redirect() -> route('employee-hidden-reference.index') -> with('msg-error', "This item is already used.");
    	}
    }
}
