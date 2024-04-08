<?php

namespace App\Modules\Payroll\Http\Controllers\Bills;


use App\Functions\EmployeeFunction;
use App\Http\Controllers\Controller;
use App\Modules\Payroll\Models\Bills\BillsSetup;
use App\Modules\Payroll\Models\Bills\BillsType;
use App\Modules\Payroll\Models\Bills\EmployeeBills;
use App\Modules\Payroll\Models\Bills\EmployeeBillsTmp;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * BillsTypeController
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Date: 15-03-2022
 * This is used for the Dynamic Section Of Bill Management
 */
class EmployeeBillsController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
        $_SESSION['SubMenuActive'] = 'Payroll-emp-bills';
    }

    public function index()
    {
        $data['employeeBills'] = EmployeeBills::get();
        return view('Payroll::Bills/EmployeeBills/index', compact('data'));
    }

    public function createOrEdit($id)
    {
        $data['employeeBills'] = empty($id) ? null : EmployeeBills::findOrFail($id);
        $data['billsType'] = empty($id) ? BillsType::select('id', 'bill_type')->pluck('bill_type', 'id') :
            BillsSetup::select('bills_setup.id', 'bills_type.bill_type')
                ->join('bills_type', 'bills_type.id', '=', 'bills_setup.bill_type_id')
                ->where('bills_setup.id', $data['employeeBills']->bill_setup_id)
                ->pluck('bills_type.bill_type', 'bills_setup.id');
        $data['allEmployees'] = EmployeeFunction::allEmployees();
        $data['status'] = ['' => 'please select', 1 => 'Active', 2 => 'Inactive'];
        return view('Payroll::Bills/EmployeeBills/createOrUpdate', compact('data'));
    }


    public function storeOrUpdate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'employee_id' => 'required',
            'bill_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = [
                'employee_id' => $request->input('employee_id'),
                'bill_setup_id' => $request->input('bill_setup_id'),
                'bill_amount' => $request->input('bill_amount'),
                'status' => $request->input('status'),
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now(),
            ];

            if (empty($request->id)) {
                $bill_setup = BillsSetup::where([
                    'bill_type_id' => $request->input('bill_setup_id'),
                    'designation_id' => $request->input('designation_id')
                ])->first();

                if (!$bill_setup) {
                    return Redirect()->back()->with('msg-error', 'Bill Information Not Found');
                }

                $data = [
                    'employee_id' => $request->input('employee_id'),
                    'bill_setup_id' => $bill_setup->id,
                    'bill_amount' => $request->input('bill_amount'),
                    'created_by' => auth()->user()->id
                ];

                EmployeeBills::create($data);
                return Redirect()->back()->with('msg-success', 'Employee Bill Successfully Created');
            }

            EmployeeBills::findOrFail($request->id)->update($data);
            return Redirect()->back()->with('msg-success', 'Employee Bill Successfully Updated');

        } catch (\Exception $e) {
            \Log::info('EmployeeBillsController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    public function storeOrUpdate1(Request $request)
    {
        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'employee_id' => 'required',
                'bill_amount' => 'required|numeric',
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $EmployeeBills = new EmployeeBills();
            if (empty($request->id)) {
                $bill_setup_id = BillsSetup::select('bills_setup.id')
                    ->where('bills_setup.bill_type_id', $inputs['bill_setup_id'])
                    ->where('bills_setup.designation_id', $inputs['designation_id'])->first();
                if (!empty($bill_setup_id)) {
                    $data = [
                        'employee_id' => $inputs['employee_id'],
                        'bill_setup_id' => $bill_setup_id->id,
                        'bill_amount' => $inputs['bill_amount'],
                        'created_by' => auth()->user()->id
                    ];
                    $EmployeeBills->fill($data)->save();
                    return Redirect()->back()->with('msg-success', 'Employee Bill Successfully Created');
                } else {
                    return Redirect()->back()->with('msg-error', 'Bill Information Not Found');
                }

            } else {
                $data = ['employee_id' => $inputs['employee_id'],
                    'bill_setup_id' => $inputs['bill_setup_id'],
                    'bill_amount' => $inputs['bill_amount'],
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()];
                $EmployeeBills->findOrFail($request->id)->update($data);
                return Redirect()->back()->with('msg-success', 'Employee Bill Successfully Updated');
            }

        } catch (\Exception $e) {
            \Log::info('EmployeeBillsController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function destroy($id): RedirectResponse
    {
        try {
            EmployeeBills::findOrFail($id)->delete();
            return Redirect()->back()->with('msg-success', 'Bill Type Successfully Deleted');

        } catch (\Exception $e) {
            \Log::info('EmployeeBillsController-destroy-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function viewTempBill()
    {
        $data['employeeBills'] = EmployeeBillsTmp::get();
        return view('Payroll::Bills/EmployeeBills/tmpBills', compact('data'));
    }

    public function editTmpBill($id)
    {
        $data['employeeBills'] = EmployeeBillsTmp::findOrFail($id);
        $data['allEmployees'] = EmployeeFunction::allEmployees();
        $data['status'] = ['' => 'please select', 1 => 'Active', 2 => 'Inactive'];
        return view('Payroll::Bills/EmployeeBills/tmpBillsUpdate', compact('data'));
    }

    public function updateTmpBill(Request $request)
    {
        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'employee_id' => 'required',
                'bill_amount' => 'required|numeric',
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $EmployeeBills = new EmployeeBillsTmp();
            $data = ['employee_id' => $inputs['employee_id'],
                'bill_amount' => $inputs['bill_amount'],
                'status' => $inputs['status'],
                'remarks' => $inputs['remarks'],
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now()];
            $EmployeeBills->findOrFail($request->id)->update($data);
            return Redirect()->back()->with('msg-success', 'Employee Bill Successfully Updated');
        } catch (\Exception $e) {
            \Log::info('EmployeeBillsController-UpdateTmpBill-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }
}