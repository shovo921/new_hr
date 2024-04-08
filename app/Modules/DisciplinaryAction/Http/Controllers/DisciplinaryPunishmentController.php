<?php

namespace App\Modules\DisciplinaryAction\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Modules\DisciplinaryAction\Models\DisciplinaryAction;
use App\Modules\DisciplinaryAction\Models\DisciplinaryActionHistory;
use App\Modules\DisciplinaryAction\Models\DisciplinaryPunishments;
use App\Modules\DisciplinaryCategory\Models\DisciplinaryCategory;
use App\Modules\Employee\Models\EmployeeDetails;

use DB;

class DisciplinaryPunishmentController extends Controller
{
    /**
     * This function is for viewing punishments
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disciplinaryPunishments = DisciplinaryPunishments::get();

        return  view("DisciplinaryAction::view_punishments",compact('disciplinaryPunishments'));
    }
    /**
     * This function is for creating punishments
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

        $type = array(
            ''=>'-- Please Select --',
            '1' =>  'Minor',
            '2' => 'Major',
        );


        return  view("DisciplinaryAction::create_punishments",compact('status','type'));
    }
    /**
     * This function is for storing punishments
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array(
            'punishments'=>'required',
            'type'=>'required',
            'status'=>'required|int',
        ));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }



        $data = array(
            'punishments' => $request->punishments,
            'type' => (int)$request->type,
            'status' => (int)$request->status
        );
        $disciplinaryPunishments= new DisciplinaryPunishments();
        $disciplinaryPunishments->fill($data)->save();
        return Redirect()->back()->with('msg-success', 'Disciplinary Punishments Successfully Added');
    }
    /**
     * This function is for editing punishments
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disciplinaryPunishment = DisciplinaryPunishments::findOrFail($id);

        $status = array(
            ''=>'-- Please Select --',
            '1' =>  'Active',
            '2' => 'Inactive',
        );

        $type = array(
            ''=>'-- Please Select --',
            '1' =>  'Minor',
            '2' => 'Major',
        );

        return  view("DisciplinaryAction::edit_punishments",compact('status','type','disciplinaryPunishment'));

    }
    /**
     * This function is for updating punishments
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $disciplinaryPunishment = DisciplinaryPunishments::findOrFail($id);
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array(
            'punishments'=>'required',
            'type'=>'required',
            'status'=>'required|int',
        ));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $data = array(
            'punishments' => $request->punishments,
            'type' => (int)$request->type,
            'status' => (int)$request->status
        );

        DisciplinaryPunishments::find($id)->update($data);

        return Redirect() -> back() -> with('msg-success', 'Disciplinary Punishment Successfully Updated');

    }
    /**
     * This function is for deleting punishments
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $model = DisciplinaryPunishments::find($id);
            $model->delete();
            return Redirect() -> back() -> with('msg-success', 'Successfully Deleted.');
        }
        catch (\Exception $e) {
            return Redirect() -> back() -> with('msg-error', "This item is already used.");
        }

    }


}
