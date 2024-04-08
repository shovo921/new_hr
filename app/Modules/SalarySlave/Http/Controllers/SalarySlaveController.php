<?php

namespace App\Modules\SalarySlave\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Designation\Models\Designation;
use App\Modules\Employee\Models\SalarySlave;

class SalarySlaveController extends Controller
{

    public function __construct(){
		$_SESSION["MenuActive"] = "settings";
	}
    public function index()
    {
        $_SESSION["SubMenuActive"] = "salary-slave";

        $salary_slaves = SalarySlave::get();
        
        return view('SalarySlave::index',compact('salary_slaves'));
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


    	return view('SalarySlave::create',compact('designations', 'status'));
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
            'designation_id'=>'required',
            'basic_salary'=>'required|numeric|between:0,99999999999999.99',
            'house_rent'=>'required|numeric|between:0,99999999999999.99',
            'increment_amount'=>'required|numeric|between:0,99999999999999.99',
            'medical'=>'required|numeric|between:0,99999999999999.99',
            'conveyance'=>'required|numeric|between:0,99999999999999.99',
            'house_maintenance'=>'required|numeric|between:0,99999999999999.99',
            'utility'=>'required|numeric|between:0,99999999999999.99',
            'lfa'=>'required|numeric|between:0,99999999999999.99',
            'car_allowance'=>'required|numeric|between:0,99999999999999.99',
            'consolidated_amount'=>'required|numeric|between:0,99999999999999.99',
            'status'=>'int|required'
        ));

        
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        

        $spec = new SalarySlave();
        $spec->fill($inputs)->save();

        return Redirect() -> to('salary-slave') -> with('msg-success', 'Salary Slave Successfully Created');
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
        $salary_slave = SalarySlave::findOrFail($id);
        
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

        $designations = $this->makeDD(Designation::pluck('designation', 'id'));

        return view('SalarySlave::edit',compact('salary_slave', 'designations', 'status') );
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
        $salary_slave = SalarySlave::findOrFail($id);
        $inputs = $request->all();

        /*echo '<pre color="red">';
        print_r($inputs);
        echo '</pre>';
        exit();*/
        
        $validator = \Validator::make($inputs, array(
            'designation_id'=>'required',
            'basic_salary'=>'required|numeric|between:0,99999999999999.99',
            'house_rent'=>'required|numeric|between:0,99999999999999.99',
            'increment_amount'=>'required|numeric|between:0,99999999999999.99',
            'medical'=>'required|numeric|between:0,99999999999999.99',
            'conveyance'=>'required|numeric|between:0,99999999999999.99',
            'house_maintenance'=>'required|numeric|between:0,99999999999999.99',
            'utility'=>'required|numeric|between:0,99999999999999.99',
            'lfa'=>'required|numeric|between:0,99999999999999.99',
            'car_allowance'=>'required|numeric|between:0,99999999999999.99',
            'consolidated_amount'=>'required|numeric|between:0,99999999999999.99',
            'status'=>'int|required'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$SalarySlaveInfo['designation_id'] = $inputs['designation_id'];
        $SalarySlaveInfo['basic_salary'] = $inputs['basic_salary'];
        $SalarySlaveInfo['house_rent'] = $inputs['house_rent'];
        $SalarySlaveInfo['increment_amount'] = $inputs['increment_amount'];
        $SalarySlaveInfo['medical'] = $inputs['medical'];
        $SalarySlaveInfo['conveyance'] = $inputs['conveyance'];
        $SalarySlaveInfo['house_maintenance'] = $inputs['house_maintenance'];
        $SalarySlaveInfo['utility'] = $inputs['utility'];
        $SalarySlaveInfo['consolidated_amount'] = $inputs['consolidated_amount'];
        $SalarySlaveInfo['car_allowance'] = $inputs['car_allowance'];
        $SalarySlaveInfo['lfa'] = $inputs['lfa'];
    	$SalarySlaveInfo['status'] = $inputs['status'];


    	SalarySlave::where('id', $id)->update($SalarySlaveInfo);

		return Redirect() -> to('salary-slave') -> with('msg-success', 'Salary Slave Successfully Updated.');
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
            SalarySlave::destroy($id);
            return Redirect() -> to('salary-slave') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('salary-slave') -> with('msg-error', "This item is already used.");
    	}
    }
}
