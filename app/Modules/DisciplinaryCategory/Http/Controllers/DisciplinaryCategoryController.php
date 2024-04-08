<?php

namespace App\Modules\DisciplinaryCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\DisciplinaryCategory\Models\DisciplinaryCategory;

class DisciplinaryCategoryController extends Controller
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
        $_SESSION["SubMenuActive"] = "disciplinary-category";
        
    	$disciplinaryCategories = DisciplinaryCategory::where('deleted_at','=',null)->get();

        return view("DisciplinaryCategory::index", compact('disciplinaryCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('DisciplinaryCategory::create');
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

        $validator = \Validator::make($inputs, array('name'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $disciplinaryCategory = new DisciplinaryCategory();
        $disciplinaryCategory->fill($inputs)->save();

        return Redirect() -> to('disciplinary-category') -> with('msg_success', 'Disciplinary Category Successfully Created');
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
        $disciplinaryCategory = DisciplinaryCategory::findOrFail($id);
        
        return view('DisciplinaryCategory::edit',compact('disciplinaryCategory'));
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
        $disciplinaryCategory = DisciplinaryCategory::findOrFail($id);
        $inputs = $request->all();
        //dd($inputs);

        $validator = \Validator::make($inputs, array('name'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $disciplinaryCategoryInfo['name'] = $inputs['name'];
        $disciplinaryCategoryInfo['status'] = $inputs['status'];

        DisciplinaryCategory::find($id)->update($disciplinaryCategoryInfo);

        return Redirect() -> to('disciplinary-category') -> with('msg_success', 'Disciplinary Category Successfully Updated');
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
            DisciplinaryCategory::destroy($id);
            return Redirect() -> route('disciplinary-category.index') -> with('msg-success', 'Successfully Deleted.');
        }
        catch (\Exception $e) {
            return Redirect() -> route('disciplinary-category.index') -> with('msg-error', "This item is already used.");
        }
    }
}
