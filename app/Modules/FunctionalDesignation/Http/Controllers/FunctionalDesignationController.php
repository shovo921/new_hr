<?php

namespace App\Modules\FunctionalDesignation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\FunctionalDesignation\Models\FunctionalDesignation;

class FunctionalDesignationController extends Controller
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
    	$_SESSION["SubMenuActive"] = "FunctionalDesignation";

        $functionalDesignation = FunctionalDesignation::get();
        
        return view("FunctionalDesignation::index", compact('functionalDesignation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('FunctionalDesignation::create');
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
    		'designation'=>'required'
    	));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$functionalDesignation = new FunctionalDesignation();
    	$functionalDesignation->fill($inputs)->save();

    	return Redirect() -> to('functional-designation') -> with('msg-success', 'Functional Designation Successfully Created');
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
    	$functionalDesignation = FunctionalDesignation::findOrFail($id);

    	return view('FunctionalDesignation::edit',compact('functionalDesignation'));
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
        $Functionaldesignation = FunctionalDesignation::findOrFail($id);
    	$inputs = $request->all();
        //dd($inputs);

    	$validator = \Validator::make($inputs, array(
    		'designation'=>'required'
    	));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
        }
        
        $designationInfo["designation"] = $request->designation;
        $designationInfo["status"] = $request->status;
        FunctionalDesignation::find($id)->update($designationInfo);

    	return Redirect() -> to('functional-designation') -> with('msg-success', 'Functional Designation Successfully Updated');
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
            FunctionalDesignation::destroy($id);
    		return Redirect() -> to('functional-designation')-> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('functional-designation') -> with('msg-error', "This item is already used.");
    	}
    }
}
