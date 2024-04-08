<?php

namespace App\Modules\Specialization\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Specialization\Models\Specialization;

class SpecializationController extends Controller
{
    public function __construct(){
        $_SESSION["MenuActive"] = "settings";
    }

    public function index()
    {
        $_SESSION["SubMenuActive"] = "specialization";
        
        $Specializations = Specialization::get();
        return view('Specialization::index',compact('Specializations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Specialization::create');
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
            'specilized_area'=>'required'
        ));

        
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        

        $spec = new Specialization();
        $spec->fill($inputs)->save();

        return Redirect() -> to('specialization') -> with('msg_success', 'Specialization Successfully Created');
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
        $specialization = Specialization::findOrFail($id);
        return view('Specialization::edit',compact('specialization') );
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
    	$specialization = Specialization::findOrFail($id);

    	$inputs = $request->all();
    	
        $validator = \Validator::make($inputs, array(
            'specilized_area'=>'required'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$specInfo['specilized_area'] = $inputs['specilized_area'];


    	Specialization::where('id', $id)->update($specInfo);

		return Redirect() -> to('specialization') -> with('msg_success', 'Specialization Successfully Updated.');
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
            Specialization::destroy($id);
            return Redirect() -> to('specialization') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('specialization') -> with('msg-error', "This item is already used.");
    	}
    }
}
