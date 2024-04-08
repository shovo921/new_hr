<?php

namespace App\Modules\ReportingManagers\Http\Controllers;

use App\Http\Controllers\Controller;


use App\Modules\Branch\Models\Branch;
use App\Modules\ReportingManagers\Models\ReportingManagers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

use Log;
use DB;

class ReportingManagersController extends Controller
{

    public function __construct() {
        $_SESSION["MenuActive"] = "settings";
        $_SESSION['SubMenuActive'] = 'reporting-heads';
    }
    public function index()
    {
        $managersList = ReportingManagers::get();
        return view("ReportingManagers::index", compact('managersList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = array(
            ''=>'---Please Select---',
            '1'=>'Yes',
            '0'=>'No'
        );
        $branchList = $this->makeDD(Branch::orderBy('branch_name')->pluck('branch_name', 'id'));
        return view('ReportingManagers::create',compact('permission','branchList'));
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
            'branch_id'=>'required',
            'md'=>'required',
            'dmd_cro'=>'required',
            'dmd_coo'=>'required',
        ));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $subject = new ReportingManagers();
        $subject->fill($inputs)->save();

        return Redirect() -> to('reporting-heads') -> with('msg_success', 'Reporting Managers Head Successfully Created');
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
        $managers = ReportingManagers::findOrFail($id);
        $permission = array(
            ''=>'---Please Select---',
            '1'=>'Yes',
            '0'=>'No'
        );
        $branchList = $this->makeDD(Branch::orderBy('branch_name')->pluck('branch_name', 'id'));

        return view('ReportingManagers::edit',compact('managers','permission','branchList'));
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
        $managers = ReportingManagers::findOrFail($id);
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array(
            'branch_id'=>'required',
            'md'=>'required',
            'dmd_cro'=>'required',
            'dmd_coo'=>'required',
        ));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        // $division->fill($inputs)->save();
        $managersInfo['branch_id'] = $inputs['branch_id'];
        $managersInfo['md'] = $inputs['md'];
        $managersInfo['dmd_cro'] = $inputs['dmd_cro'];
        $managersInfo['dmd_coo'] = $inputs['dmd_coo'];


        ReportingManagers::where('id', $id)->update($managersInfo);

        return Redirect() -> to('reporting-heads') -> with('msg_success', 'Reporting Managers Head  Successfully Updated');
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

            ReportingManagers::destroy($id);
            return Redirect() -> to('reporting-heads') -> with('msg-success', 'Successfully Deleted.');
        }
        catch (\Exception $e) {
            return Redirect() -> to('reporting-heads') -> with('msg-error', "This item is already used.");
        }
    }
}
