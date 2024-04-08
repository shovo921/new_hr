<?php

namespace App\Modules\BrDivision\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\BrDivision\Models\BrDivision;
use App\Modules\Branch\Models\Branch;


class BrDivisionController extends Controller
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
    	$_SESSION["SubMenuActive"] = "br-division";

    	$br_division = BrDivision::get();

        return view("BrDivision::index", compact('br_division'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branchList = $this->makeDD(Branch::orderBy('branch_name')->pluck('branch_name', 'id')); //where('branch_id', 'not like', 'H%')->
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

    	return view('BrDivision::create',compact('branchList','status'));
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
    		'br_name'=>'required',
    		'br_id'=>'required|int',
    		'br_details'=>'required',
    		'br_status'=>'required|int'
    	));
        
    	if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$br = new BrDivision();
        $br->fill($inputs)->save();
        
        
    	return Redirect() -> to('br-division') -> with('msg_success', 'Branch Division Successfully Created');
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
    	$br_division = BrDivision::findOrFail($id);
        $branchList = $this->makeDD(Branch::orderBy('branch_name')->pluck('branch_name', 'id'));//where('branch_id', 'not like', 'H%')->
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );
        return view('BrDivision::edit',compact('br_division','branchList','status'));

        
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
        $br_division = BrDivision::findOrFail($id);
    	$inputs = $request->all();

    	$validator = \Validator::make($inputs, array(
    		'br_name'=>'required',
    		'br_id'=>'required|int',
    		'br_details'=>'required',
    		'br_status'=>'required|int'
    	));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        //dd($inputs);
        
        $brDivInfo["br_name"] = $request->br_name;
        $brDivInfo["br_id"] = $request->br_id;
        $brDivInfo["br_details"] = $request->br_details;
        $brDivInfo["br_status"] = $request->br_status;

        BrDivision::where('id', $id)->update($brDivInfo);

    	return Redirect() -> to('br-division') -> with('msg_success', 'Branch Division Successfully Updated');
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
            BrDivision::destroy($id);
            return Redirect() -> to('br-division') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('br-division') -> with('msg-error', "This item is already used.");
    	}
    }
}
