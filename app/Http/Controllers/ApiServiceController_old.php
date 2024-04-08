<?php

namespace App\Http\Controllers;

use App\Models\ApiService;
use Illuminate\Http\Request;
use Validator;

class ApiServiceControllerOld extends Controller
{
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string',
            'user_name' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
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

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials=$request->only(['user_name','password']);
        if (! $token = auth('auth_service')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',]);
    }
}
