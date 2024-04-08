<?php

return [
    'enable_sms_sending' => env('ENABLE_SMS_SENDING','no'),
    /*
     * Number of login otp one user can send in one day
     */
    'max_num_of_login_otp_in_one_day' => 20,
    /*
     * Number of forget password token one user can send in one day
     */
    'max_num_of_forget_token_in_one_day' => 10,
    /*
     * SMS credential for English and Bangla
     */
    //English
//    'sms_user_en' => 'rnd_dept',
//    'sms_password_en' => '33d=4Z72',
//    'sms_sid_en' => 'SSLTESTAPI',
    'sms_user_en' => 'SafariTicket',
    'sms_password_en' => 'i71>8O44',
    'sms_sid_en' => 'SafariTicketNon',
    //Bangla
//    'sms_user_bn' => '',
//    'sms_password_bn' => '',
//    'sms_sid_bn' => '',

    'sms_text_for_login_otp' => "Your login otp is __otp__",
    'sms_text_for_otp' => "Your otp is __otp__",

    'sms_text_for_forget_password' => "Your forget password token is __otp__",

    'sms_text_transaction'=>'Your purchase ticket request is successfully complete. Your invoice no is __inv__. Please show this SMS in the ticket counter.',
    /*Billing Api Details*/


    
];
