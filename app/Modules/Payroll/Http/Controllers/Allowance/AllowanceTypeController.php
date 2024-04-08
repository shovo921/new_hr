<?php

namespace App\Modules\Payroll\Http\Controllers\Allowance;


use App\Http\Controllers\Controller;
use App\Modules\Payroll\Models\Allowance\AllowanceType;
use Illuminate\Http\Request;

/**
 * AllowanceTypeController
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Date: 09-01-2022
 * This is used for the Dynamic Section Of Employee Allowance
 */

class AllowanceTypeController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    public function index()
    {
        $data['allowanceType'] = AllowanceType::get();
        return view('Payroll::Allowance/AllowanceType/index', compact('data'));
    }

    public function create()
    {
        $data['allowanceType'] = null;
        $data['status'] = array(
            '' => 'Please Select',
            '1' => 'Active',
            '2' => 'InActive',
        );
        return view('Payroll::Allowance/AllowanceType/create', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'allowance_type' => 'required'
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $allowance = new AllowanceType();
            $allowance->fill($inputs)->save();
            return Redirect()->back()->with('msg-success', 'Allowance Type Successfully Created');

        }  catch (\Exception $e) {
            \Log::info('AllowanceTypeController-store-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function edit($id)
    {

        $data['allowanceType'] = AllowanceType::findOrFail($id);
        $data['status'] = array(
            '' => 'Please Select',
            '1' => 'Active',
            '2' => 'InActive',
        );
        return View('Payroll::Allowance/AllowanceType/edit', compact('data'));

    }

    public function update(Request $request, $id)
    {
        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'allowance_type' => 'required'
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $allowance = new AllowanceType();
            $allowance->findOrFail($id)->fill($inputs)->save();
            return Redirect()->back()->with('msg-success', 'Allowance Type Successfully Updated');

        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


}