<?php

namespace App\Modules\SalaryHead\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\SalaryHead\Models\SalaryHead;

class SalaryHeadController extends Controller
{

    public function __construct(){
		$_SESSION["MenuActive"] = "settings";
	}
    public function index()
    {
        $_SESSION["SubMenuActive"] = "salary-head";
        $salary_heads = SalaryHead::get();
        
        return view('SalaryHead::index',compact('salary_heads'));
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

        $variable_status = array(
            'Fixed' =>  'Fixed',
            'Variable' => 'Variable',
        );

        $head_types = array(
            'Inductive' =>  'Inductive',
            'Deductive' => 'Deductive',
        );

        $salary_heads = $this->makeDD(SalaryHead::where('status', '1')->pluck('salary_head', 'id'));

    	return view('SalaryHead::create',compact('salary_heads', 'variable_status', 'head_types', 'status'));
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
            'salary_head'=>'required',
            'head_type'=>'required',
            'percentage'=>'int|required',
            'status'=>'int|required'
        ));

        
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        

        $spec = new SalaryHead();
        $spec->fill($inputs)->save();

        return Redirect() -> to('salary-head') -> with('msg_success', 'Salary Head Successfully Created');
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
        $salary_head = SalaryHead::findOrFail($id);
        
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

        $variable_status = array(
            'Fixed' =>  'Fixed',
            'Variable' => 'Variable',
        );

        $head_types = array(
            'Inductive' =>  'Inductive',
            'Deductive' => 'Deductive',
        );

        $salary_heads = $this->makeDD(SalaryHead::where('status', '1')->pluck('salary_head', 'id'));

        
        return view('SalaryHead::edit',compact('salary_head','status', 'variable_status', 'head_types', 'salary_heads'));
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
        $Salary_heads = SalaryHead::findOrFail($id);
        $inputs = $request->all();
        
        $validator = \Validator::make($inputs, array(
            'salary_head'=>'required',
            'head_type'=>'required',
            'percentage'=>'int|required',
            'status'=>'int|required'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$SalaryHeadInfo['salary_head'] = $inputs['salary_head'];
    	$SalaryHeadInfo['is_variable'] = $inputs['is_variable'];
    	$SalaryHeadInfo['parent_head_id'] = $inputs['parent_head_id'];
    	$SalaryHeadInfo['head_type'] = $inputs['head_type'];
    	$SalaryHeadInfo['percentage'] = $inputs['percentage'];
    	$SalaryHeadInfo['status'] = $inputs['status'];

            //dd($SalaryHeadInfo);
    	SalaryHead::where('ID', $id)->update($SalaryHeadInfo);

		return Redirect() -> to('salary-head') -> with('msg_success', 'Salary Heads Successfully Updated.');
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
            SalaryHead::destroy($id);
            return Redirect() -> to('salary-head') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('salary-head') -> with('msg-error', "This item is already used.");
    	}
    }
}
