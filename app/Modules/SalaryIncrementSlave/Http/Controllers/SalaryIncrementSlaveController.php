<?php

namespace App\Modules\SalaryIncrementSlave\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Designation\Models\Designation;
use App\Modules\Employee\Models\SalaryIncrementSlave;

class SalaryIncrementSlaveController extends Controller
{

    public function __construct(){
		$_SESSION["MenuActive"] = "settings";
	}
    public function index()
    {
        $_SESSION["SubMenuActive"] = "salary-increment-slave";
        $salary_increment_slaves = SalaryIncrementSlave::get();
        
        return view('SalaryIncrementSlave::index',compact('salary_increment_slaves'));
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

        $designations = $this->makeDD(Designation::pluck('designation', 'id'));

    	return view('SalaryIncrementSlave::create',compact('designations', 'status'));
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
        //dd($inputs);
        $validator = \Validator::make($inputs, array(
            'designation_id'=>'required',
            'basic_salary'=>'int|required',
            'increment_amount'=>'int|required',
            'inc_slave_no'=>'int|required|between:0,20',
        ));

        
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }


        $spec = new SalaryIncrementSlave();
        $spec->fill($inputs)->save();


        return Redirect() -> to('salary-increment-slave') -> with('msg-success', 'Salary Increment Slave Successfully Created');
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
    public function edit($id) {
        $salary_increment_slave = SalaryIncrementSlave::findOrFail($id);
        
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

        $designations = $this->makeDD(Designation::pluck('designation', 'id'));

        return view('SalaryIncrementSlave::edit',compact('salary_increment_slave', 'designations', 'status') );
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
        $salary_increment_slave = SalaryIncrementSlave::findOrFail($id);
        $inputs = $request->all();

        /*echo '<pre color="red">';
        print_r($inputs);
        echo '</pre>';
        exit();*/
        
        $validator = \Validator::make($inputs, array(
            'designation_id'=>'required',
            'basic_salary'=>'int|required',
            'increment_amount'=>'int|required',
            'inc_slave_no'=>'int|required|between:0,20',
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$SalaryIncrementSlaveInfo['designation_id'] = $inputs['designation_id'];
        $SalaryIncrementSlaveInfo['basic_salary'] = $inputs['basic_salary'];
        $SalaryIncrementSlaveInfo['increment_amount'] = $inputs['increment_amount'];
        $SalaryIncrementSlaveInfo['inc_slave_no'] = $inputs['inc_slave_no'];


    	SalaryIncrementSlave::where('id', $id)->update($SalaryIncrementSlaveInfo);

		return Redirect() -> to('salary-increment-slave') -> with('msg-success', 'Salary Increment Slave Successfully Updated.');
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
            SalaryIncrementSlave::destroy($id);
            return Redirect() -> to('salary-increment-slave') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('salary-increment-slave') -> with('msg-error', "This item is already used.");
    	}
    }
}
