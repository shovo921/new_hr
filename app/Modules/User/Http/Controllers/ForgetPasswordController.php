<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Models\ForgetPasswordRequests;
use Illuminate\Http\Request;
use App\User;
use Log;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Traits\OtpAndTokenTrait;

class ForgetPasswordController extends Controller {

    use OtpAndTokenTrait;

    public function form() {
        return view('password.forget-form');
    }

    public function sendOtp(Request $request) {
        $this->validate($request, [
            'mobile_no' => [
                'required',
                Rule::exists('users')->where(function ($query) {
                            $query->where('type', 'system');
                        })
            ]
        ]);

        $user = User::where('mobile_no', $request->mobile_no)->where('type', 'system')->first();
        $otp = $this->Otp($request->mobile_no, 'forget_password', 'system', $user);

        if ($otp['status']) {
            return redirect()->route('forget-password.otp-view');
        } else {
            return redirect()->back()->withErrors(['mobile_no' => $otp['message']]);
        }
    }

    public function formOtp() {
        return view('password.forget-pwd-otp');
    }

    public function otpVerify(Request $request) {
        $this->validate($request, [
            'mobile_no' => [
                'required',
                Rule::exists('otps', 'mobile')->where(function ($query) {
                            $query->where('user_type', 'system')->where('type', 'forget_password');
                        })
            ],
            'otp' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);

        $data = $this->verifyOtp($request->mobile_no, $request->otp, 'forget_password', 'system', false);

        if ($data['status']) {
            $user = User::findOrFail($data['data']->user_id);
            $user->password = Hash::make($request->password);
            $user->save();
            $this->verifyOtp($request->mobile_no, $request->otp, 'forget_password', 'system', true);
            
            return redirect()->route('login')->with('success',"Password Reset Successfully. Please Login");
        } else {
            return redirect()->back()->withErrors(['otp'=>"Invalid OTP"])->withInput();
        }
    }

    public function forgetPassword(Request $request){
        $passwordRequest = new ForgetPasswordRequests();
        $inputs = $request->all();
        $user =User::select('employee_id')->where('employee_id',$request->employee_id)->first();
        $checkRequest = ForgetPasswordRequests::where('employee_id',$request->employee_id)->orderby('request_time', 'desc')->first();
        $validator = \Validator::make($inputs, array(
            'employee_id'=>'required|int',
        ));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        if (!empty($user->employee_id)) {
            if( empty($checkRequest->request_status) || $checkRequest->request_status == 2){
                //dd('HH',$checkRequest->request_status);
                $passwordRequest->employee_id =$request->employee_id;
                $passwordRequest->ip_address =$_SERVER['REMOTE_ADDR'];;
                $passwordRequest->request_time = Carbon::now();
                $passwordRequest->save();
                return Redirect()->back()->with('success', 'Password Change Request Accepted');
            }else if($checkRequest->request_status == 1) {
                //dd('HH1',$checkRequest->request_status);
                return Redirect() -> back() -> withErrors('You Have a Pending Request') -> withInput();
            }

        } else {
            return Redirect()->back()-> withErrors('Password Change Request Failed')-> withInput();
        }
    }

}
