<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Traits;

use Log;

/**
 *
 * @author arnob
 */
trait SendSmsApiTrait
{

    /**
     * Send SMS to user mobile no.
     *
     * @param $msisdn
     * @param $sms
     */
    private function __getUrl($sms, $msisdn, $type = 'en')
    {

        if ($type === 'en') {
            return 'http://sms.sslwireless.com/pushapi/dynamic/server.php?user=' . config('config.sms_user_en') . '&pass=' . config('config.sms_password_en') . '&sid=' . config('config.sms_sid_en') . '&sms=' . urlencode($sms) . '&msisdn=' . $msisdn . '&csmsid=123456789';
        } else {
            return 'http://sms.sslwireless.com/pushapi/dynamic/server.php?user=' . config('config.sms_user_bn') . '&pass=' . config('config.sms_password_bn') . '&sid=' . config('config.sms_sid_bn') . '&sms=' . urlencode($sms) . '&msisdn=' . $msisdn . '&csmsid=889977';
        }
    }

    public function sendMessageEn($msisdn, $sms)
    {
        if (config('config.enable_sms_sending') == 'no') {
            return;
        }

        $curl = curl_init();
        curl_setopt_array(
            $curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->__getUrl($sms, $msisdn, 'en'),
                CURLOPT_USERAGENT => 'Sample cURL Requests'
            ]
        );


        if (curl_error($curl)) {
            Log::error(curl_error($curl));
            $response = null;
        } else {
            $response = curl_exec($curl);
        }

        curl_close($curl);
        Log::info($msisdn."--".$sms);
        return $response;
    }

    public function sendMessageBn($msisdn, $sms)
    {
        if (config('config.enable_sms_sending') == 'no') {
            return;
        }
        //unicode convertions
        $sms = strtoupper(bin2hex(iconv('UTF-8', 'UCS-2BE', $sms)));
        $curl = curl_init();
        curl_setopt_array(
            $curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->__getUrl($sms, $msisdn, 'bn'),
                CURLOPT_USERAGENT => 'Sample cURL Requests'
            ]
        );

        if (curl_error($curl)) {
            Log::error(curl_error($curl));
            $response = null;
        } else {
            $response = curl_exec($curl);
        }

        curl_close($curl);

        return $response;
    }

    /*
      public function sendBulkSms($sms) {

      // $url="http://sms.sslwireless.com/pushapi/dynamic/server.php"; $param="user=".config('app.sms_user')."&pass=".config('app.sms_password')."&sms[0][0]= 880XXXXXXXXXX &sms[0][1]=".urlencode("Test SMS 1")."&sms[0][2]=123456789&sms[1][0]= 880XXXXXXXXXX &sms[1][1]=".urlencode("Test SMS &2")."&sms[1][2]=123456790&sid=".config('app.sid');

      $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
      $param = "user=" . config('app.sms_user') . "&pass=" . config('app.sms_password') . "$sms&sid=" . config('app.sms_sid');
      $crl = curl_init();
      curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($crl, CURLOPT_URL, $url);
      curl_setopt($crl, CURLOPT_HEADER, 0);
      curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($crl, CURLOPT_POST, 1);
      curl_setopt($crl, CURLOPT_POSTFIELDS, $param);
      $response = curl_exec($crl);
      curl_close($crl);
      Log::info($response);
      }
     *
     */
}
