<?php

namespace App\Modules\Thana\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Thana\Models\Thana;
use App\Modules\Division\Models\Division;
use App\Modules\District\Models\District;

class ThanaController extends Controller
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
    	$_SESSION["SubMenuActive"] = "thana";

    	$thanas = Thana::get();

        return view("Thana::index", compact('thanas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$divisionList = $this->makeDD(Division::orderBy('name')->pluck('name', 'id'));
    	$districtList = $this->makeDD(District::orderBy('name')->pluck('name', 'id'));

    	return view('Thana::create', compact('divisionList', 'districtList'));
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
    		'name'=>'required', 
    		'district_id'=>'required|int', 
    		'division_id'=>'required|int'
    	));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$thana = new Thana();
    	$thana->fill($inputs)->save();

    	return Redirect() -> to('thana') -> with('msg_success', 'Thana Successfully Created');
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
    	$thana = Thana::findOrFail($id);

    	$divisionList = $this->makeDD(Division::orderBy('name')->pluck('name', 'id'));
    	$districtList = $this->makeDD(District::orderBy('name')->pluck('name', 'id'));

    	return view('Thana::edit',compact('thana', 'divisionList', 'districtList'));
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
        $thana = Thana::findOrFail($id);
        //dd($thana);
    	$inputs = $request->all();

    	$validator = \Validator::make($inputs, array(
    		'name'=>'required', 
    		'district_id'=>'required|int', 
    		'division_id'=>'required|int'
    	));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        //dd($inputs);
        
        $thanaInfo["name"] = $request->name;
        $thanaInfo["division_id"] = $request->division_id;
        $thanaInfo["district_id"] = $request->district_id;

        Thana::where('id', $id)->update($thanaInfo);

    	return Redirect() -> to('thana') -> with('msg_success', 'Thana Successfully Updated');
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
    		Thana::destroy($id);
    		return Redirect() -> route('thana.index') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
    		return Redirect() -> route('thana.index') -> with('msg-error', "This item is already used.");
    	}
    }

    public function getDistricts(Request $request) {
        $data = District::where('division_id', $request->division_id)->orderBy('name')->get();

        $option = '<option value="">--Please Select--</option>';
        
        foreach ($data as $key => $value) {
            $option .= '<option value='.$value->id.' >'.$value->name.'</option>';
        }
        return $option;
    }

    public function getThanas(Request $request) {
        $data = Thana::where('district_id', $request->district_id)->get();

        $option = '<option value="">--Please Select--</option>';
        
        foreach ($data as $key => $value) {
            $option .= '<option value='.$value->id.' >'.$value->name.'</option>';
        }
        return $option;
    }
}
