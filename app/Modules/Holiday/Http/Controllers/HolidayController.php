<?php

namespace App\Modules\Holiday\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Holiday\Models\Holiday;


class HolidayController extends Controller
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
        $_SESSION["SubMenuActive"] = "holiday";
        
//    	$holidays = Holiday::all();
        $holidays=Holiday::whereYear('HOLIDAY_DATE', now()->year)->get();
        return view("Holiday::index", compact('holidays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Holiday::create');
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

        $validator = \Validator::make($inputs, [
            'holiday_date' => 'required|date|unique:HOLIDAY,holiday_date',
        ]);
        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }
        $data = array(
            'holiday_date' => $request->holiday_date,
            'description' => $request->description,
        );
        $holiday = new Holiday();
        $holiday->fill($data)->save();

        return Redirect() -> to('holiday') -> with('msg_success', 'Holiday Successfully Created');
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
        $holiday = Holiday::findOrFail($id);
        $holiday->holiday_date = date('Y-m-d', strtotime($holiday->holiday_date));
        return view('Holiday::edit',compact('holiday'));
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
        $holiday = Holiday::findOrFail($id);
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array('holiday_date'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $HolidayInfo['holiday_date'] = $inputs['holiday_date'];
        $HolidayInfo['description'] = $inputs['description'];

        Holiday::where('id', $id)->update($HolidayInfo);

        return Redirect() -> to('holiday') -> with('msg_success', 'Holiday Successfully Updated');
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
            Holiday::destroy($id);
            return Redirect() -> route('holiday.index') -> with('msg-success', 'Successfully Deleted.');
        }
        catch (\Exception $e) {
            return Redirect() -> route('holiday.index') -> with('msg-error', "This item is already used.");
        }
    }
}
