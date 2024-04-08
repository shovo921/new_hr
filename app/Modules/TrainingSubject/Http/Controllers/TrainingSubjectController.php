<?php

namespace App\Modules\TrainingSubject\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\ProfessionalInstitue\Models\ProfessionalInstitue;
use App\Modules\TrainingSubject\Models\TrainingSubject;
use Illuminate\Http\Request;

class TrainingSubjectController extends Controller
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
        return view("TrainingSubject::welcome");
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $_SESSION["SubMenuActive"] = "division";

        $trainingSubject = TrainingSubject::all();

        return view("TrainingSubject::index", compact('trainingSubject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('TrainingSubject::create');
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

        $validator = \Validator::make($inputs, array('subject_name'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $subject = new TrainingSubject();
        $subject->fill($inputs)->save();

        return Redirect() -> to('training-subject') -> with('msg_success', 'Training Subject Name Successfully Created');
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
        $subject = TrainingSubject::findOrFail($id);

        return view('TrainingSubject::edit',compact('subject'));
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
        $institute = TrainingSubject::findOrFail($id);
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array('subject_name'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        // $division->fill($inputs)->save();
        $InstituteInfo['subject_name'] = $inputs['subject_name'];


        TrainingSubject::where('id', $id)->update($InstituteInfo);

        return Redirect() -> to('training-subject') -> with('msg_success', 'Training Subject Name Successfully Updated');
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
