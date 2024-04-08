<?php

namespace App\Modules\JobStatus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\JobStatus\Models\JobStatus;

class JobStatusController extends Controller
{
    public function __construct(){
		$_SESSION["MenuActive"] = "settings";
	}
    public function index()
    {
        $_SESSION["SubMenuActive"] = "job-status";

        $job_statuses = JobStatus::get();
        return view('JobStatus::index',compact('job_statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

    	return view('JobStatus::create',compact('status'));
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
            'job_status'=>'required',
            'status'=>'int|required'
        ));

        
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        

        $spec = new JobStatus();
        $spec->fill($inputs)->save();

        return Redirect() -> to('job-status') -> with('msg_success', 'Job Status Successfully Created');
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
        $job_status = JobStatus::findOrFail($id);
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );
        return view('JobStatus::edit',compact('job_status','status') );
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
        $job_status = JobStatus::findOrFail($id);
        $inputs = $request->all();
        
        $validator = \Validator::make($inputs, array(
            'job_status'=>'required',
            'status'=>'int|required'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$jobStatusInfo['job_status'] = $inputs['job_status'];
    	$jobStatusInfo['status'] = $inputs['status'];


    	JobStatus::where('id', $id)->update($jobStatusInfo);

		return Redirect() -> to('job-status') -> with('msg_success', 'Job status Successfully Updated.');
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
            JobStatus::destroy($id);
            return Redirect() -> to('job-status') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('job-status') -> with('msg-error', "This item is already used.");
    	}
    }
}
