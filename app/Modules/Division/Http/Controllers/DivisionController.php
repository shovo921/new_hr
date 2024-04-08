<?php

namespace App\Modules\Division\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Division\Models\Division;


class DivisionController extends Controller
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
        $_SESSION["SubMenuActive"] = "division";
        
    	$divisions = Division::all();

        return view("Division::index", compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Division::create');
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

        $division = new Division();
        $division->fill($inputs)->save();

        return Redirect() -> to('division') -> with('msg_success', 'Division Successfully Created');
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
        $division = Division::findOrFail($id);
        
        return view('Division::edit',compact('division'));
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
        $division = Division::findOrFail($id);
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array('name'=>'required'));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        // $division->fill($inputs)->save();
        $DivisionInfo['name'] = $inputs['name'];


        Division::where('id', $id)->update($DivisionInfo);

        return Redirect() -> to('division') -> with('msg_success', 'Division Successfully Updated');
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
            Division::destroy($id);
            return Redirect() -> route('division.index') -> with('msg-success', 'Successfully Deleted.');
        }
        catch (\Exception $e) {
            return Redirect() -> route('division.index') -> with('msg-error', "This item is already used.");
        }
    }
}
