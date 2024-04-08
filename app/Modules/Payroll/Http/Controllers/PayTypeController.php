<?php

namespace App\Modules\Payroll\Http\Controllers;

use App\Functions\EmployeeFunction;
use App\Http\Controllers\Controller;
use App\Modules\Payroll\Models\GlPl;
use App\Modules\Payroll\Models\DeductionType;
use App\Modules\Payroll\Models\PayType;
use Carbon\Carbon;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;


class PayTypeController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$test = EmployeeFunction::procedureTest();
        //dd($test);
        $_SESSION["SubMenuActive"] = "payroll-settings-pay";
        $payType_lists = PayType::get();

        return view('Payroll::PayType/index', compact('payType_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $status = array(
            '' => '-- Please Select --',
            'A' => 'Active',
            'I' => 'Inactive'
        );

        return view('Payroll::PayType/create', compact('status'));
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
        $pay_type = new PayType();
        $pay_type->fill($data)->save();
        return Redirect()->back()->with('msg-success', 'Payment Type Successfully Created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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
        $payType_list = PayType::where('ptype_id', $id)->first();

        $status = array(
            '' => '-- Please Select --',
            'A' => 'Active',
            'I' => 'Inactive'
        );

        return view('Payroll::PayType/edit', compact('payType_list', 'status'));
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
        $payType_list = PayType::where('ptype_id', $id)->first();
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

        PayType::where('ptype_id',$id)->update($data);
        return Redirect() ->back()-> with('msg-success', 'Payment Type Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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


    /**
     * This function will return Head information based on type
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getHead(Request $request)
    {
        $pay_type_list = $this->makeDD(PayType::where('status', 'A')->pluck('description', 'ptype_id'));
        $deduction_type_list = $this->makeDD(DeductionType::where('status', 'A')->pluck('description', 'dtype_id'));
        if ($request->typeId == 'p'){
            return $pay_type_list;
        }else{
            return $deduction_type_list;
        }
    }
}
