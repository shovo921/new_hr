<?php

namespace App\Modules\Payroll\Http\Controllers\Bills;


use App\Http\Controllers\Controller;
use App\Modules\Designation\Models\Designation;
use App\Modules\Payroll\Models\Bills\BillsSetup;
use App\Modules\Payroll\Models\Bills\BillsType;
use Carbon\Carbon;
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
class BillsSetupController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    public function index()
    {
        $data['billsSetup'] = BillsSetup::get();
        return view('Payroll::Bills/BillsSetup/index', compact('data'));
    }

    public function createOrEdit($id)
    {
        $data['billsSetup'] = empty($id) ? null : BillsSetup::findOrFail($id);
        $data['billsType'] = BillsType::select('id', 'bill_type')->pluck('bill_type', 'id');
        $data['designation'] = Designation::select('id', 'designation')->orderby('seniority_order')->pluck('designation', 'id');
        $data['status'] = ['' => 'please select', 1 => 'Active', 2 => 'Inactive'];
        return view('Payroll::Bills/BillsSetup/createOrUpdate', compact('data'));
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'bill_type_id' => 'required',
                'designation_id' => 'required',
                'bill_amount' => 'required|numeric',
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $billsSetup = new BillsSetup();
            if (empty($request->id)) {
                $data = [$inputs, ['created_by' => auth()->user()->id]];
                $createdData = array_merge($data[0], $data[1]);
                $billsSetup->fill($createdData)->save();
                return Redirect()->back()->with('msg-success', 'Bill Type Successfully Created');
            } else {
                $data = [$inputs, ['updated_by' => auth()->user()->id, 'updated_at' => Carbon::now()]];

                $billsSetup->findOrFail($request->id)->update($data[0], $data[1]);
                return Redirect()->back()->with('msg-success', 'Bill Type Successfully Updated');
            }

        } catch (\Exception $e) {
            \Log::info('BillsSetupController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function destroy($id): RedirectResponse
    {
        try {
            BillsSetup::findOrFail($id)->delete();
            return Redirect()->back()->with('msg-success', 'Bill Type Successfully Deleted');

        } catch (\Exception $e) {
            \Log::info('BillsSetupController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }


}