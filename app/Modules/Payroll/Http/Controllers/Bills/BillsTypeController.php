<?php

namespace App\Modules\Payroll\Http\Controllers\Bills;


use App\Http\Controllers\Controller;
use App\Modules\Payroll\Models\Bills\BillsType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * BillsTypeController
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Date: 14-03-2022
 * This is used for the Dynamic Section Of Bill Management
 */
class BillsTypeController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    public function index()
    {
        $data['billsType'] = BillsType::get();
        return view('Payroll::Bills/BillsType/index', compact('data'));
    }

    public function createOrEdit($id)
    {
        $data['billsType'] = empty($id) ? null : BillsType::findOrFail($id);
        return view('Payroll::Bills/BillsType/createOrUpdate', compact('data'));
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'bill_type' => 'required'
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $billsType = new BillsType();
            if (empty($request->id)) {
                $billsType->fill($inputs)->save();
                return Redirect()->back()->with('msg-success', 'Bill Type Successfully Created');
            } else {
                $billsType->findOrFail($request->id)->update($inputs);
                return Redirect()->back()->with('msg-success', 'Bill Type Successfully Updated');
            }

        } catch (\Exception $e) {
            \Log::info('BillsTypeController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function destroy($id): RedirectResponse
    {
        try {
            BillsType::findOrFail($id)->delete();
            return Redirect()->back()->with('msg-success', 'Bill Type Successfully Deleted');

        } catch (\Exception $e) {
            \Log::info('BillsTypeController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }


}