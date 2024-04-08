<?php

namespace App\Modules\TourType\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\TourType\Models\TourType;

class TourTypeController extends Controller
{
    public function __construct(){
		$_SESSION["MenuActive"] = "settings";
	}
    public function index()
    {
        $_SESSION['SubMenuActive'] = 'tour-type';
        
        $tour_types = TourType::get();
        return view('TourType::index',compact('tour_types'));
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

    	return view('TourType::create',compact('status'));
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
            'tour_types'=>'required',
            'status'=>'int|required'
        ));

        
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        

        $spec = new TourType();
        $spec->fill($inputs)->save();

        return Redirect() -> to('tour-type') -> with('msg_success', 'Tour Type Successfully Created');
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
        $tour_type = TourType::findOrFail($id);
        
        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );
        
        return view('TourType::edit',compact('tour_type','status') );
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
        $tour_type = TourType::findOrFail($id);
        $inputs = $request->all();
        
        $validator = \Validator::make($inputs, array(
            'tour_types'=>'required',
            'status'=>'int|required'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$tourTypeInfo['tour_types'] = $inputs['tour_types'];
    	$tourTypeInfo['status'] = $inputs['status'];


    	TourType::where('id', $id)->update($tourTypeInfo);

		return Redirect() -> to('tour-type') -> with('msg_success', 'Tour Type Successfully Updated.');
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
            TourType::destroy($id);
            return Redirect() -> to('tour-type') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('tour-type') -> with('msg-error', "This item is already used.");
    	}
    }
}
