<?php

namespace App\Modules\EducationExam\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EducationExam;
use App\Models\EducationLevel;
use Illuminate\Http\Request;

class EducationExamController extends Controller
{
    private $educationExamLevels = [
        '' => '-- Please Select --',
        '1' => 'Secondary',
        '2' => 'Higher Secondary',
        '3' => 'Graduate',
        '4' => 'Post Graduate',
        '5' => 'JSC',
    ];


    private $status = [
        '' => '-- Please Select --',
        '1' => 'Active',
        '2' => 'In-Active',
    ];


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
        return view("EducationExam::welcome");
    }


    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $_SESSION["SubMenuActive"] = "employee-education";

        $educationExam = EducationExam::all();

        return view("EducationExam::index", compact('educationExam'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $educationExamLevels = $this->educationExamLevels;
        $status = $this->status;
        return view('EducationExam::create',compact('educationExamLevels','status'));
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

        $validator = \Validator::make($inputs, array('examination'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $institute = new EducationExam();
        $institute->fill($inputs)->save();

        return Redirect() -> to('education-exam') -> with('msg_success', 'Examination Name Successfully Created');
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
        $educationExam = EducationExam::findOrFail($id);

        $educationExamLevels = $this->educationExamLevels;
        $status = $this->status;
        return view('EducationExam::edit',compact('educationExam','educationExamLevels','status'));
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
        $institute = EducationExam::findOrFail($id);
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array('examination'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        // $division->fill($inputs)->save();
        $InstituteInfo['examination'] = $inputs['examination'];


        EducationExam::where('id', $id)->update($InstituteInfo);

        return Redirect() -> to('education-exam') -> with('msg_success', 'Exam Name Successfully Updated');
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

            EducationExam::destroy($id);
            return Redirect() -> route('education-exam.index') -> with('msg-success', 'Successfully Deleted.');
        }
        catch (\Exception $e) {
            return Redirect() -> route('education-exam.index') -> with('msg-error', "This item is already used.");
        }
    }
}
