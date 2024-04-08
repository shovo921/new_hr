<?php

namespace App\Modules\LeaveType\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\LeaveType\Models\LeaveType;
use App\Modules\Leave\Models\LeaveEligibilitie;

use Carbon\Carbon;

class LeaveTypeController extends Controller
{
	public function __construct(){
		$_SESSION["MenuActive"] = "leave";
	}

	/**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		$_SESSION['SubMenuActive'] = 'leave-types';

		$leaveTypes = LeaveType::get();
		return view('LeaveType::index',compact('leaveTypes'));
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
    	$leaveEligibilities = $this->makeDD(LeaveEligibilitie::pluck('eligibility', 'id'));

        $forwardStatus = array(
            '' => '-- Please Select --',
            '0' => 'No',
            '1' => 'Yes'
        );

    	return view('LeaveType::create', compact('leaveEligibilities', 'forwardStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array(
            'leave_type'=>'required',
            'eligibility_id'=>'int|required',
            'total_leave_per_year'=>'int|required',
            'max_taken_at_a_time'=>'int|required',
            'carried_forward_status'=>'int|required',
            'max_carried_forward'=>'int',
        ));

        
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $inputs['created_by'] = auth()->user()->id;
        $inputs['created_at'] = Carbon::now();

        $leaveType = new LeaveType();

        $leaveType->fill($inputs)->save();

        return Redirect() -> to('leave-type') -> with('msg_success', 'Leave Type Successfully Created');
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
        $leaveType = LeaveType::findOrFail($id);

        $leaveEligibilities = $this->makeDD(LeaveEligibilitie::pluck('eligibility', 'id'));

        $forwardStatus = array(
            '' => '-- Please Select --',
            '0' => 'No',
            '1' => 'Yes'
        );

        return view('LeaveType::edit',compact('leaveType', 'leaveEligibilities', 'forwardStatus'));
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
        $leaveType = LeaveType::findOrFail($id);
        $inputs = $request->all();
        
        $validator = \Validator::make($inputs, array(
            'leave_type'=>'required',
            'eligibility_id'=>'int|required',
            'total_leave_per_year'=>'int|required',
            'max_taken_at_a_time'=>'int|required',
            'carried_forward_status'=>'int|required',
            'max_carried_forward'=>'int',
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$leaveTypeUpdate['leave_type'] = $inputs['leave_type'];
    	$leaveTypeUpdate['eligibility_id'] = $inputs['eligibility_id'];
    	$leaveTypeUpdate['total_leave_per_year'] = $inputs['total_leave_per_year'];
    	$leaveTypeUpdate['max_taken_at_a_time'] = $inputs['max_taken_at_a_time'];
    	$leaveTypeUpdate['carried_forward_status'] = $inputs['carried_forward_status'];
    	$leaveTypeUpdate['max_carried_forward'] = $inputs['max_carried_forward'];
    	$leaveTypeUpdate['updated_by'] = auth()->user()->id;
        $leaveTypeUpdate['updated_at'] = Carbon::now();

    	LeaveType::where('ID', $id)->update($leaveTypeUpdate);

		return Redirect() -> to('leave-type') -> with('msg_success', 'Leave Type Successfully Updated.');
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
    		LeaveType::destroy($id);
    		return Redirect() -> route('leave-type.index') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
    		return Redirect() -> route('leave-type.index') -> with('msg-error', "This item is already used.");
    	}
    }
}
