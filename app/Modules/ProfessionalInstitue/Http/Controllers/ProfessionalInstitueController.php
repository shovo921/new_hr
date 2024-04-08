<?php

namespace App\Modules\ProfessionalInstitue\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProfessionalInstitue\Models\ProfessionalInstitue;
use Illuminate\Http\Request;

class ProfessionalInstitueController extends Controller
{
    public function __construct(){
        $_SESSION["MenuActive"] = "settings";
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("ProfessionalInstitue::welcome");
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $_SESSION["SubMenuActive"] = "division";

        $professionalInstitue = ProfessionalInstitue::all();

        return view("ProfessionalInstitue::index", compact('professionalInstitue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ProfessionalInstitue::create');
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

        $validator = \Validator::make($inputs, array('institute_name'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $institute = new ProfessionalInstitue();
        $institute->fill($inputs)->save();

        return Redirect() -> to('professional-institue') -> with('msg_success', 'Institute Name Successfully Created');
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
        $institute = ProfessionalInstitue::findOrFail($id);

        return view('ProfessionalInstitue::edit',compact('institute'));
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
        $institute = ProfessionalInstitue::findOrFail($id);
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array('institute_name'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        // $division->fill($inputs)->save();
        $InstituteInfo['institute_name'] = $inputs['institute_name'];


        ProfessionalInstitue::where('id', $id)->update($InstituteInfo);

        return Redirect() -> to('professional-institue') -> with('msg_success', 'Professional Institute Name Successfully Updated');
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

            ProfessionalInstitue::destroy($id);
            return Redirect() -> route('professional-institue.index') -> with('msg-success', 'Successfully Deleted.');
        }
        catch (\Exception $e) {
            return Redirect() -> route('professional-institue.index') -> with('msg-error', "This item is already used.");
        }
    }
}
