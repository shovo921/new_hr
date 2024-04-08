<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


define('ENCRYPTION_KEY', '__^%&Q@$&*!@#$%^&*^__');
class Openssl_EncryptDecrypt
{
    function encrypt($pure_string, $encryption_key)
    {
        $cipher = 'AES-256-CBC';
        $options = OPENSSL_RAW_DATA;
        $hash_algo = 'sha256';
        $sha2len = 32;
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($pure_string, $cipher, $encryption_key, $options, $iv);
        $hmac = hash_hmac($hash_algo, $ciphertext_raw, $encryption_key, true);
        return $iv . $hmac . $ciphertext_raw;
    }

    function decrypt($encrypted_string, $encryption_key)
    {
        $cipher = 'AES-256-CBC';
        $options = OPENSSL_RAW_DATA;
        $hash_algo = 'sha256';
        $sha2len = 32;
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($encrypted_string, 0, $ivlen);
        $hmac = substr($encrypted_string, $ivlen, $sha2len);
        $ciphertext_raw = substr($encrypted_string, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $encryption_key, $options, $iv);
        $calcmac = hash_hmac($hash_algo, $ciphertext_raw, $encryption_key, true);
        if (function_exists('hash_equals')) {
            if (hash_equals($hmac, $calcmac)) return $original_plaintext;
        } else {
            if ($this->hash_equals_custom($hmac, $calcmac)) return $original_plaintext;
        }
    }

    /**
     * (Optional)
     * hash_equals() function polyfilling.
     * PHP 5.6+ timing attack safe comparison
     */
    function hash_equals_custom($knownString, $userString)
    {
        if (function_exists('mb_strlen')) {
            $kLen = mb_strlen($knownString, '8bit');
            $uLen = mb_strlen($userString, '8bit');
        } else {
            $kLen = strlen($knownString);
            $uLen = strlen($userString);
        }
        if ($kLen !== $uLen) {
            return false;
        }
        $result = 0;
        for ($i = 0; $i < $kLen; $i++) {
            $result |= (ord($knownString[$i]) ^ ord($userString[$i]));
        }
        return 0 === $result;
    }
}
class EncryptDecrypt
{
    function enc($msg, $key)
    {
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);

        $ciphertext_raw = openssl_encrypt($msg, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);

        return $ciphertext;

    }

    function decr($ciphermsg, $key)
    {
        $c = base64_decode($ciphermsg);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);

        if (function_exists('hash_equals')) {

            if (hash_equals($hmac, $calcmac)) return $original_plaintext;
        } else {
            if ($this->hash_equals_custom($hmac, $calcmac)) return $original_plaintext;
        }

//        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
//        {
//            return $original_plaintext;
//        }else {
//            return null;
//        }

    }

    function pw_hash($pw)
    {
        $options = [
            'cost' => 12,
        ];
        $pwd_hashed = password_hash($pw, PASSWORD_BCRYPT, $options);

        return $pwd_hashed;
    }

    function hash_equals_custom($knownString, $userString)
    {
        if (function_exists('mb_strlen')) {
            $kLen = mb_strlen($knownString, '8bit');
            $uLen = mb_strlen($userString, '8bit');
        } else {
            $kLen = strlen($knownString);
            $uLen = strlen($userString);
        }
        if ($kLen !== $uLen) {
            return false;
        }
        $result = 0;
        for ($i = 0; $i < $kLen; $i++) {
            $result |= (ord($knownString[$i]) ^ ord($userString[$i]));
        }
        return 0 === $result;
    }


}
class ApiServicePasswordController extends Controller
{
    public function customEncryptDecrypt($key, $type)
    {
        # type = encrypt/decrypt
        $secret = "XxOx*4e!hQqG5b~9a";
        if (!$key) {
            return false;
        }

        /*if ($type == 'decrypt') {
            $key = strtr(urldecode($key), '-_,', '+/=');
            $original = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($secret), base64_decode($key), MCRYPT_MODE_CBC, md5(md5($secret))), "\0");
            return $original;
        } elseif ($type == 'encrypt') {
            $verification_key = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($secret), $key, MCRYPT_MODE_CBC, md5(md5($secret))));
            return urlencode(strtr($verification_key, '+/=', '-_,'));
        }
        */
        if ($type == 'decrypt') {
            $key = strtr(urldecode($key), '-_,', '+/=');
            $var = new EncryptDecrypt;
            return $var->decr($key,$secret);

            // return EncryptDecrypt::decr($key,$secret);
        }
        elseif ($type == 'encrypt') {
            $var = new EncryptDecrypt;
            $verification_key = $var->enc($key,$secret);
            // $verification_key = EncryptDecrypt::enc($key,$secretenc);
            return urlencode(strtr($verification_key, '+/=', '-_,'));
        }
    }

    public function encrypt ($id){
        $encryptedKey = $this->customEncryptDecrypt($id, 'encrypt');
        $data = [
            'encryptedKey' => $encryptedKey,
             'your_value'=>  $id
            ];
        return response()->json($data);
    }
    public function decrypt ($id){
        $decryptedKey = $this->customEncryptDecrypt($id, 'decrypt');
        $data = [
            'decryptedKey' => $decryptedKey,
            'your_value'=>  $id

        ];
        return response()->json($data);
    }
}
