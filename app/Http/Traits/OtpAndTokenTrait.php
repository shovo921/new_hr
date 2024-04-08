<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Traits;

use Log;
use App\Otp;
use App\OtpCount;

/**
 *
 * @author arnob
 */
/*
 * type = login_otp,forget_password,etc
 */

trait OtpAndTokenTrait {

    use SendSmsApiTrait;

    public function Otp($mobile, $type, $user_type, $user = null) {
        $otpCount = OtpCount::where('mobile', $mobile)
                ->where('type', $type)
                ->where('user_type', $user_type)
                ->orderBy('created_at', 'desc')
                ->first();

        if ($otpCount) {
            $diff = $this->__diffBetweenTwoDateTime($otpCount->updated_at, date('Y-m-d H:i:s'));
            $returnData = $this->__canSendOtp($otpCount->count, $diff, $otpCount->type);
            if ($returnData['status']) {

                $otpCount->count = $otpCount->count + 1;
                $otpCount->ip = \Request::ip();
                $otpCount->updated_at = date('Y-m-d H:i:s');
                $otpCount->save();
            } else {

                return ['status' => false, 'message' => $returnData['message']];
            }
        } else {
            $otpCount = new OtpCount();
            $otpCount->user_id = (is_null($user)) ? null : $user->id;
            $otpCount->mobile = $mobile;
            $otpCount->count = 1;
            $otpCount->type = $type;
            $otpCount->user_type = $user_type;
            $otpCount->ip = \Request::ip();
            $otpCount->created_at = date('Y-m-d H:i:s');
            $otpCount->updated_at = date('Y-m-d H:i:s');
            $otpCount->save();
        }


        $token = $this->__sendAndStoreOtp($mobile, $type,$user_type, $user);

        $smsBody = config('config.sms_text_for_' . $type);

        $smsBody = str_replace('__otp__', $token, $smsBody);

        $this->sendMessageEn($mobile, $smsBody);

        Log::info("Otp = " . $type . ' ' . $token);

        return ['status' => true, 'message' => ''];
    }

    private function __diffBetweenTwoDateTime($fromDateTime, $toDateTime) {
        $dt1 = new \DateTime($fromDateTime);
        $dt2 = new \DateTime($toDateTime);
        return $dteDiff = $dt1->diff($dt2);
    }

    private function __canSendOtp($count, $diff, $type) {
        if ($type == 'forget_password') {
            $maxLimit = config('config.max_num_of_forget_token_in_one_day');
        } else if ($type == 'login_otp') {
            $maxLimit = config('config.max_num_of_login_otp_in_one_day');
        } else {
            $maxLimit = 0;
        }


        if ($count >= $maxLimit) {
            return ['status' => false, 'message' => __('app.exceeded_todays_limitation')];
        }

        if ($diff->h >= 1) {
            return ['status' => true, 'message' => ''];
        }

        if ($diff->i >= 1) {
            return ['status' => true, 'message' => ''];
        }

        return ['status' => false, 'message' => __('app.try_agian_after_a_while')];
    }

    public function verifyOtp($mobile, $otp, $type,$userType,$delete=true) {
        
        $data = Otp::where('mobile', $mobile)
                ->where('token', $otp)
                ->where('type', $type)
                ->where('user_type', $userType)
                ->orderBy('id', 'desc')
                ->first();

        if ($data) {
            /* remove this otp */
            if($delete)
            {
                Otp::where('id',$data->id)->delete();
            }
            
            return ['status' => true, 'data' => $data];
        } else {
            return ['status' => false, 'data' => null];
        }
    }

    private function __sendAndStoreOtp($mobile, $type,$user_type, $user = null) {
        while (1) {
            $token = rand(100000, 999999);

            if (!Otp::where('token', $token)->exists()) {
                break;
            }
        }

        $data = Otp::where('mobile', $mobile)->where('type', $type)->where('user_type',$user_type)->orderBy('created_at', 'desc');

        if (!is_null($user)) {
            $data->where('user_id', $user->id);
        }

        $data = $data->first();

        if ($data) {
            //update
            $data->token = $token;
            $data->updated_at = date('Y-m-d H:i:s');
            $data->ip = \Request::ip();
            $data->save();
        } else {
            //create
            $data = new Otp();
            $data->user_id = (is_null($user)) ? null : $user->id;
            $data->mobile = $mobile;
            $data->token = $token;
            $data->type = $type;
            $data->user_type = $user_type;
            $data->created_at = date('Y-m-d H:i:s');
            $data->updated_at = date('Y-m-d H:i:s');
            $data->ip = \Request::ip();
            $data->save();
        }

        return $token;
    }

}
