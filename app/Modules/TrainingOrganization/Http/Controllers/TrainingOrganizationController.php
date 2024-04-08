<?php

namespace App\Modules\TrainingOrganization\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProfessionalInstitue\Models\ProfessionalInstitue;
use App\Modules\TrainingOrganization\Models\TrainingOrganization;
use Illuminate\Http\Request;

class TrainingOrganizationController extends Controller
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
        $_SESSION["SubMenuActive"] = "division";

        $trainingOrganization = TrainingOrganization::all();

        return view("TrainingOrganization::index", compact('trainingOrganization'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('TrainingOrganization::create');
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

        $validator = \Validator::make($inputs, array('organization_name'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $institute = new TrainingOrganization();
        $institute->fill($inputs)->save();

        return Redirect() -> to('training-organization') -> with('msg_success', 'Organization Name Successfully Created');
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
        $institute = TrainingOrganization::findOrFail($id);

        return view('TrainingOrganization::edit',compact('institute'));
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
        $institute = TrainingOrganization::findOrFail($id);
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array('organization_name'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        // $division->fill($inputs)->save();
        $InstituteInfo['organization_name'] = $inputs['organization_name'];


        TrainingOrganization ::where('id', $id)->update($InstituteInfo);

        return Redirect() -> to('training-organization') -> with('msg_success', 'Professional Organization Name Successfully Updated');
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
            TrainingOrganization::destroy($id);
            return Redirect() -> route('training-organization.index') -> with('msg-success', 'Successfully Deleted.');
        }
        catch (\Exception $e) {
            return Redirect() -> route('training-organization.index') -> with('msg-error', "This item is already used.");
        }
    }
}
