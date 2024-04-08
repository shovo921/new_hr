<?php

namespace App\Modules\Payroll\Http\Controllers\Allowance;

use App\Functions\BranchFunction;
use App\Functions\EmployeeFunction;
use App\Http\Controllers\Controller;
use App\Modules\Payroll\Models\Allowance\AllowanceType;
use App\Modules\Payroll\Models\Allowance\EmployeeAllowance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * EmployeeAllowanceController
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Date: 09-01-2022
 * This is used for the operation of Employee Allowance
 */
class EmployeeAllowanceController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
        $_SESSION['SubMenuActive'] = "payroll-allowance";
    }

    public function allFunctions()
    {
        $data['allEmployees'] = EmployeeFunction::allEmployees();
        $data['allBranches'] = BranchFunction::allBranches();
        $data['activeBranches'] = BranchFunction::activeOrInactiveBranches(1);
        $data['inactiveBranches'] = BranchFunction::activeOrInactiveBranches(2);
        $data['branch'] = BranchFunction::headOfficeOrBranch(2);
        $data['allowanceTypes'] = AllowanceType::select(DB::raw("(allowance_type) allowance_type"), 'id')->where('status', 1)->pluck('allowance_type', 'id');
        $data['status'] = array(
            '' => 'Please Select',
            '1' => 'Initial',
            '2' => 'Active',
            '3' => 'End',
            '4' => 'Cancel'
        );
        return $data;
    }

    public function index()
    {
        $data['employeeAllowances'] = EmployeeAllowance::get();
        return view('Payroll::Allowance/EmployeeAllowance/index', compact('data'));
    }

    public function createOrEdit($id)
    {
        $allFunctions = $this->allFunctions();
        $data['allEmployees'] = $this->makeDD($allFunctions['allEmployees']);
        $data['allowanceTypes'] = $this->makeDD($allFunctions['allowanceTypes']);
        $data['status'] = $allFunctions['status'];
        if (empty($id)) {
            $data['employeeAllowances'] = null;
        } else {
            $data['employeeAllowances'] = EmployeeAllowance::findOrFail($id);

        }
        return View('Payroll::Allowance/EmployeeAllowance/createOrUpdate', compact('data'));
    }

    public function storeAndUpdate(Request $request)
    {
        try {
            $inputs = $request->all();
            $validator = \Validator::make($inputs, array(
                'disb_amount' => 'required|numeric|between:0,99999999999999.99',
            ));
            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }
            $employeeAllowance = new EmployeeAllowance();
            if (empty($inputs['id'])) {
                $data = array(
                    'employee_id' => $inputs['employee_id'],
                    'allowance_type' => $inputs['allowance_type'],
                    'disb_amount' => $inputs['disb_amount'],
                    'disb_date' => date('Y-m-d', strtotime($inputs['disb_date'])),
                    'deduct_start_month' => $inputs['deduct_start_month'],
                    'deduct_end_month' => $inputs['deduct_end_month'],
                    'created_by' => auth()->user()->id,
                    'status' => 1,
                );
                $employeeAllowance->fill($data)->save();
                return Redirect()->route('allowance.index')->with('msg-success', 'Employee Allowance Added Successfully');

            } else {
                $data = array(
                    'employee_id' => $inputs['employee_id'],
                    'allowance_type' => $inputs['allowance_type'],
                    'disb_amount' => $inputs['disb_amount'],
                    'disb_date' => date('Y-m-d', strtotime($inputs['disb_date'])),
                    'deduct_start_month' => $inputs['deduct_start_month'],
                    'deduct_end_month' => $inputs['deduct_end_month'],
                    'updated_at' => Carbon::now(),
                    'updated_by' => auth()->user()->id,
                    'status' => $inputs['status'],
                );
                $employeeAllowance->findOrFail($inputs['id'])->fill($data)->save();
                return Redirect()->route('allowance.index')->with('msg-success', 'Employee Allowance Updated Successfully');
            }

        } catch (\Exception $e) {
            \Log::info('AllowanceController-StoreOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function authorizeAllowance($id)
    {
        try {

            $employeeAllowance = new EmployeeAllowance();
            $data = array(
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->id,
                'status' => 2,
            );
            $employeeAllowance->findOrFail($id)->fill($data)->save();
            return Redirect()->route('allowance.index')->with('msg-success', 'Employee Allowance Successfully Authorized');

        } catch (\Exception $e) {
            \Log::info('AllowanceController-Authorize-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function cancelAllowance($id)
    {
        try {
            $employeeAllowance = new EmployeeAllowance();
            $data = array(
                'updated_at' => Carbon::now(),
                'updated_by' => auth()->user()->id,
                'status' => 4,
            );
            $employeeAllowance->findOrFail($id)->fill($data)->save();
            return Redirect()->route('allowance.index')->with('msg-success', 'Employee Allowance Successfully Cancelled');
        } catch (\Exception $e) {
            \Log::info('AllowanceController-Cancel-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function destroy($id)
    {
        try {
            EmployeeAllowance::destroy($id);
            return Redirect()->route('allowance.index')->with('msg-success', 'Employee Allowance Successfully Deleted');
        } catch (\Exception $e) {
            \Log::info('AllowanceController-Delete-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

}