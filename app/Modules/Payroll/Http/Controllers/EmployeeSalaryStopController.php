<?php

namespace App\Modules\Payroll\Http\Controllers;


use App\Functions\EmployeeFunction;
use App\Http\Controllers\Controller;
use App\Modules\Payroll\Models\EmployeeSalaryStop;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * EmployeeSalaryStopController
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Date: 20-03-2022
 * This is used for the Dynamic Section Of Bill Management
 */
class EmployeeSalaryStopController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    public function index()
    {
        $data['empSalStop'] = EmployeeSalaryStop::get();
        return view('Payroll::EmpSalaryStop/index', compact('data'));
    }

    public function createOrEdit($id)
    {
        $data['empSalStop'] = empty($id) ? null : EmployeeSalaryStop::findOrFail($id);
        $data['allEmployees'] = EmployeeFunction::allEmployeesWithResign();
        $data['status'] = ['' => '--Please Select--', 1 => 'Inactive', 4 => 'Stop/LWP', 5 => 'On Provision'];
        return view('Payroll::EmpSalaryStop/createOrUpdate', compact('data'));
    }

    public function storeOrUpdate(Request $request)
    {
        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'employee_id' => 'required',
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $empStopSal = new EmployeeSalaryStop();
            if (empty($request->id)) {
                $data = [
                    'employee_id' => $request->employee_id,
                    'remarks' => $request->remarks,
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                    'status' => (int)$request->status, /***** 1=Inactive,4=Stop/LWP,5=On Provision *****/
                    'created_by' => auth()->user()->id
                ];
                $empStopSal->fill($data)->save();
                return Redirect()->back()->with('msg-success', 'Information Successfully Created');
            } else {
                $data = [
                    'employee_id' => $request->employee_id,
                    'remarks' => $request->remarks,
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                    'status' => (int)$request->status, /***** 1=Active,4=Stop/LWP,5=On Provision *****/
                    'updated_by' => auth()->user()->id,
                    'updated_at' => Carbon::now()
                ];
                $empStopSal->findOrFail($request->id)->update($data);
                return Redirect()->back()->with('msg-success', 'Bill Type Successfully Updated');
            }

        } catch (\Exception $e) {
            \Log::info('EmployeeSalaryStopController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function destroy($id): RedirectResponse
    {
        try {
            EmployeeSalaryStop::findOrFail($id)->delete();
            return Redirect()->back()->with('msg-success', 'Information Successfully Deleted');

        } catch (\Exception $e) {
            \Log::info('EmployeeSalaryStopController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }


}