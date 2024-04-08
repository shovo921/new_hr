<?php

namespace App\Http\Controllers;

use App\Models\ApiService;
use App\Modules\Employee\Models\EmpInfoPadmaPortal;
use App\Models\PamdaPortalInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ApiServiceController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string',
            'user_name' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $apiuser = ApiService::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $apiuser
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = $request->only(['user_name', 'password']);
        if (!$token = auth('auth_service')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // return $this->createNewToken($token);
        // if (! $token = auth('auth_service')->attempt($validator->validated())) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',]);
    }

    public function userProfile()
    {
        $user = User::all();
        return $user;

        return response()->json(auth()->user());
    }

    public function EmpinfoPadma(Request $request)
    {


        $emp_id = $request->query('emp_id');
//        $emp_id=$request->emp_id;
        $result = DB::table('v_padma_portal_info')
            ->select('*')
            ->where('EMPLOYEE_ID', $emp_id)
            ->first();

        // Check if the result is found and return a JSON response
        if ($result) {
            return response()->json($result);
        } else {
            // Handle the case where no data is found, e.g., return a 404 response
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }


    public function branchOrDivInformation()
    {

        $result = DB::table('branch')
            ->select('id', 'branch_name', 'head_office')
            ->get();

        // Check if the result is found and return a JSON response
        if ($result) {
            return response()->json($result);
        } else {
            // Handle the case where no data is found, e.g., return a 404 response
            return response()->json(['error' => 'Branch information Not found'], 404);
        }
    }

    public function branchOrDivEmployees(Request $request)
    {


        $brDivId = $request->query('brDivId');

        $result = DB::table('v_padma_portal_info')
            ->select('*')
            ->where('branch_id', $brDivId)
            ->get();

        // Check if the result is found and return a JSON response
        if ($result) {
            return response()->json($result);
        } else {
            // Handle the case where no data is found, e.g., return a 404 response
            return response()->json(['error' => 'Employee information Not found'], 404);
        }
    }

    public function designationWiseBranchOrDivEmployees(Request $request)
    {

        $brDivId = $request->query('brDivId');
        $designationId = $request->query('designationId');

        $result = DB::table('v_padma_portal_info')
            ->select('*')
            ->where('branch_id', $brDivId)
            ->where('designation_id', $designationId)
            ->get();

        // Check if the result is found and return a JSON response
        if ($result) {
            return response()->json($result);
        } else {
            // Handle the case where no data is found, e.g., return a 404 response
            return response()->json(['error' => 'Employee information Not found'], 404);
        }
    }


    public function allEmpinfoPadma(Request $request)
    {

        // $result = DB::table('EMP_INFO_PADMAPORTAL')
        //     ->select('*')
        //     ->get();
        $result = DB::table('v_padma_portal_info')
            ->select('*')
            ->get();
        // $result=DB::SELECT('select * from V_PADMA_PORTAL_INFO');


        // Check if the result is found and return a JSON response
        if ($result) {
            return response()->json($result);
        } else {
            // Handle the case where no data is found, e.g., return a 404 response
            return response()->json(['error' => 'Employee not found'], 404);
        }
    }

}
