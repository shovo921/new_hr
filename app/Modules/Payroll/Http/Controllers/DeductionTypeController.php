<?php

namespace App\Modules\Payroll\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payroll\Models\DeductionType;
use App\Modules\Payroll\Models\PayType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;


use Illuminate\Http\Response;
use Illuminate\View\View;


class DeductionTypeController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    /**
     * Display the module welcome screen
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $_SESSION["SubMenuActive"] = "payroll-settings-deduct";
        $dedType_lists = DeductionType::get();

        return view('Payroll::DeductionType/index', compact('dedType_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $_SESSION["SubMenuActive"] = "payroll-settings-deduct";

        $status = array(
            '' => '-- Please Select --',
            'A' => 'Active',
            'I' => 'Inactive'
        );

        return view('Payroll::DeductionType/create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $_SESSION["SubMenuActive"] = "payroll-settings-deduct";
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array(
            'description' => 'required',
            'status' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }
        $data = array(
            'description' => $request->description,
            'status' => $request->status
        );
        $deduction_type = new DeductionType();
        $deduction_type->fill($data)->save();
        return Redirect()->back()->with('msg-success', 'DeductionType Successfully Created');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(Request $request)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $_SESSION["SubMenuActive"] = "payroll-settings-deduct";
        $dedType_list = DeductionType::where('dtype_id', $id)->first();

        $status = array(
            '' => '-- Please Select --',
            'A' => 'Active',
            'L' => 'Loan',
            'I' => 'Inactive'
        );

        return view('Payroll::DeductionType/edit', compact('dedType_list', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $_SESSION["SubMenuActive"] = "payroll-settings-deduct";
        $dedType_list = DeductionType::where('dtype_id', $id)->first();
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array(
            'description' => 'required',
            'status' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array(
            'description' => $request->description,
            'status' => $request->status
        );

        DeductionType::where('dtype_id', $id)->update($data);
        return Redirect()->back()->with('msg-success', 'DeductionType Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        /*        try {
                    Division::destroy($id);
                    return Redirect() -> route('division.index') -> with('msg-success', 'Successfully Deleted.');
                }
                catch (\Exception $e) {
                    return Redirect() -> route('division.index') -> with('msg-error', "This item is already used.");
                }*/
    }

}
