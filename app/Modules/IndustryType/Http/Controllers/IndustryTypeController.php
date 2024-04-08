<?php

namespace App\Modules\IndustryType\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\IndustryType\Models\IndustryType;

class IndustryTypeController extends Controller
{
    public function __construct(){
		$_SESSION["MenuActive"] = "settings";
	}

    public function index()
    {
        $_SESSION["SubMenuActive"] = "tour-type";
        
        $industry_type = IndustryType::get();
        return view('IndustryType::index',compact('industry_type'));
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

    	return view('IndustryType::create',compact('status'));
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
            'industry_type'=>'required',
            'status'=>'int|required'
        ));

        
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        

        $spec = new IndustryType();
        $spec->fill($inputs)->save();

        return Redirect() -> to('industry-type') -> with('msg_success', 'Industry Type Successfully Created');
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
        $Industry_type = IndustryType::findOrFail($id);
        
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

        return view('IndustryType::edit',compact('industry_type','status') );
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
        $Industry_type = IndustryType::findOrFail($id);
        $inputs = $request->all();
        
        $validator = \Validator::make($inputs, array(
            'industry_type'=>'required',
            'status'=>'int|required'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$IndustryTypeInfo['industry_type'] = $inputs['industry_type'];
    	$IndustryTypeInfo['status'] = $inputs['status'];


    	IndustryType::where('id', $id)->update($IndustryTypeInfo);

		return Redirect() -> to('industry-type') -> with('msg_success', 'Industry Type Successfully Updated.');
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
    		IndustryType::destroy($id);
    		return Redirect() -> route('industry-type.index') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
    		return Redirect() -> route('industry-type.index') -> with('msg-error', "This item is already used.");
    	}
    }
}
