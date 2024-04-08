<?php

namespace App\Modules\Payroll\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\Payroll\Models\ApiInfo;
use App\Modules\Payroll\Models\SalaryAccount;
use App\Modules\Employee\Models\EmployeeDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Modules\Division\Models\Division;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class SalaryAccountController extends Controller
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
    public function index(Request $request)
    {
        $_SESSION["SubMenuActive"] = "payroll-salary-account";
        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        /** Generate The API Token To get The Account Information */
        //$this->saveToken();

        $employeeList = $this->makeDD($employeeData);

        $salaryAccount = $this->__allSalaryAccountFilter($request);


        return view('Payroll::SalaryAccount/view', compact('salaryAccount', 'employeeList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeeList = EmployeeDetails::select(DB::raw("(employee_details.employee_id || ' - ' || employee_details.employee_name) employee_name"), 'employee_details.employee_id')
            ->whereRaw('employee_id NOT IN(select EMPLOYEE_ID from EMPLOYEE_SALARY_ACCOUNT where STATUS=1)')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $this->saveToken();
        $branchList = $this->makeDD(Branch::where('head_office', 2)->orderBy('branch_name')->pluck('branch_name', 'id'));


        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive'
        );

        return view('Payroll::SalaryAccount/create', compact('employeeList', 'status', 'branchList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $inputs = $request->all();

            $validator = \Validator::make($inputs, array(
                'employee_id' => 'required',
                'branch_id' => 'required',
                //'account_no' => ['required', Rule::unique('employee_salary_account')->ignore($request->id)],
                'account_no' => ['required'],
                'customer_id' => 'required',
                'status' => 'required|int'
            ));

            if ($validator->fails()) {
                return Redirect()->back()->withErrors($validator)->withInput();
            }

            $status = SalaryAccount::select('status')
                ->where('employee_id', $request->employee_id)
                ->first();

            if (!empty($status)) {
                if ($status->status == 1) {
                    return Redirect()->back()->with('msg-error', 'SalaryAccount Already Exists');

                } else {
                    $salaryAccount = new SalaryAccount();

                    $data = array(
                        'employee_id' => $request->employee_id,
                        'status' => (int)$request->status,
                        'branch_id' => (int)$request->branch_id,
                        'account_no' => $request->account_no,
                        'customer_id' => $request->customer_id,
                        'created_by' => auth()->user()->id,
                    );
                    $salaryAccount->fill($data)->save();

                    return Redirect()->back()->with('msg-success', 'SalaryAccount Successfully Created');

                }

            } else {

                $data = array(
                    'employee_id' => $request->employee_id,
                    'branch_id' => (int)$request->branch_id,
                    'account_no' => $request->account_no,
                    'customer_id' => $request->customer_id,
                    'created_by' => auth()->user()->id,
                    'status' => (int)$request->status
                );


                $salaryAccount = new SalaryAccount();
                $salaryAccount->fill($data)->save();

                return Redirect()->back()->with('msg-success', 'SalaryAccount Successfully Created');

            }
        } catch (\Exception $e) {
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $employeeData = EmployeeDetails::select(DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
            ->where('status', 1)
            ->pluck('employee_name', 'employee_id');

        $employeeList = $this->makeDD($employeeData);

        $salaryAccount = $this->__allSalaryAccountFilter($request);


        return view('Payroll::SalaryAccount/view', compact('salaryAccount', 'employeeList'));
    }

    /**
     * Display the module welcome screen
     *
     * @return Response
     */

    private function __allSalaryAccountFilter($request)
    {
        $salaryAccount = SalaryAccount::query();

        if ($request->filled('employee_id')) {
            $salaryAccount->where('employee_id', $request->employee_id);
        }
        $salaryAccount->where('status', 1);
        return $salaryAccount->paginate(10);
    }

    public function edit($id)
    {
        $salaryAccount = SalaryAccount::findOrFail($id);
        $this->saveToken();
        $status = array(
            '' => '-- Please Select --',
            '1' => 'Active',
            '2' => 'Inactive'
        );

        return view('Payroll::SalaryAccount/edit', compact('salaryAccount', 'status'));
    }

    public function update(Request $request)
    {
        $inputs = $request->all();


        $validator = \Validator::make($inputs, array(
            'employee_id' => 'required',
            'branch_id' => 'required',
            'account_no' => 'required',
            'customer_id' => 'required',
            'status' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array(
            'employee_id' => $request->employee_id,
            'branch_id' => (int)$request->branch_id,
            'account_no' => $request->account_no,
            'customer_id' => $request->customer_id,
            'updated_by' => auth()->user()->id,
            'updated_at' => Carbon::now(),
            'status' => (int)$request->status
        );


        SalaryAccount::findOrFail($request->id)->update($data);
        return Redirect()->back()->with('msg-success', 'Employee SalaryAccount Successfully Updated');
    }

    public function authLogin()
    {
        $apiInfo = ApiInfo::first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$apiInfo->url",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                      "userId": "' . $apiInfo->user_id . '",
                      "password": "' . $apiInfo->password . '"
                    }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . "$apiInfo->basic_auth",
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    public function saveToken()
    {
        try {
            $token = json_decode($this->authLogin());
            $data = [
                'token' => $token->AccessToken,
                'token_updated_at' => Carbon::now()
            ];
            ApiInfo::whereIn('id', [1, 2])->update($data);
            return 'success';
        } catch (\Exception $e) {
            dd($e);
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }


    }

    public function getAccInfo($accNo)
    {

        $apiInfo = ApiInfo::where('id', 2)->first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiInfo->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                    "TrnHeader":
                                    {

                                    "UserName": "' . $apiInfo->user_id . '",
                                    "Password": "' . $apiInfo->password . '",
                                    "BasicAuthKey":  "' . $apiInfo->basic_auth . '"
                                    },
                                    "TrnBody":
                                    {
                                    "DestAccountNo": "' . $accNo . '"
                                    }
                                }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . "$apiInfo->token",
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);


        curl_close($curl);

        return $response;
    }
}
