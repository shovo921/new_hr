<?php

namespace App\Modules\TransferType\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\TransferType\Models\TransferType;

class TransferTypeController extends Controller
{

    public function __construct(){
		$_SESSION["MenuActive"] = "settings";
	}
    public function index()
    {
        $transfer_types = TransferType::get();
        
        return view('TransferType::index',compact('transfer_types'));
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

    	return view('TransferType::create',compact('status'));
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
            'transfer_type'=>'required',
            'status'=>'int|required'
        ));

        
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        

        $spec = new TransferType();
        $spec->fill($inputs)->save();

        return Redirect() -> to('transfer-type') -> with('msg_success', 'Transfer Type Successfully Created');
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
        $transfer_type = TransferType::findOrFail($id);
        
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );
        
        return view('TransferType::edit',compact('transfer_type','status') );
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
        $transfer_type = TransferType::findOrFail($id);
        $inputs = $request->all();
        
        $validator = \Validator::make($inputs, array(
            'transfer_type'=>'required',
            'status'=>'int|required'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$TransferTypeInfo['transfer_type'] = $inputs['transfer_type'];
    	$TransferTypeInfo['status'] = $inputs['status'];


    	TransferType::where('id', $id)->update($TransferTypeInfo);

		return Redirect() -> to('transfer-type') -> with('msg_success', 'Transfer Type Successfully Updated.');
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
