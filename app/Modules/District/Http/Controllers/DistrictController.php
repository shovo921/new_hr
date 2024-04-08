<?php

namespace App\Modules\District\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Division\Models\Division;
use App\Modules\District\Models\District;

class DistrictController extends Controller
{
	/*public function __construct(){
		$_SESSION["MenuActive"] = "administration";
	}*/
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
    	$_SESSION["SubMenuActive"] = "district";

    	$districts = District::get();

    	return view("District::index", compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$divisionList = $this->makeDD(Division::pluck('name', 'id'));

    	return view('District::create', compact('divisionList'));
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

    	$validator = \Validator::make($inputs, array('name'=>'required', 'division_id'=>'required|int'));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$district = new District();
    	$district->fill($inputs)->save();

    	return Redirect() -> to('district') -> with('msg_success', 'District Successfully Created');
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
    	$district = District::findOrFail($id);

    	$divisionList = $this->makeDD(Division::pluck('name', 'id'));

    	return view('District::edit',compact('district', 'divisionList'));
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
    	$district = District::findOrFail($id);

    	$inputs = $request->all();
    	
    	$validator = \Validator::make($inputs, array('name'=>'required', 'division_id'=>'required|int'));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$districtInfo['name'] = $inputs['name'];
    	$districtInfo['division_id'] = $inputs['division_id'];


    	District::where('id', $id)->update($districtInfo);

		return Redirect() -> to('district') -> with('msg_success', 'District Successfully Updated.');
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
    		District::destroy($id);
    		return Redirect() -> route('district.index') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
    		return Redirect() -> route('district.index') -> with('msg-error', "This item is already used.");
    	}
    }
}
