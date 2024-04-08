<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\LoginActivityLog;
use App\Models\LoginActivity;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\User\Models\ForgetPasswordRequests;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Log;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use PHPUnit\Exception;
use Spatie\Permission\Models\Role;

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

/**
 * Encryption and Decryption Class
 * This Class is used for the SSO Module
 */
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


class SystemUserController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */

    public static function allEmployees()
    {
        try {
            return EmployeeDetails::select(\Illuminate\Support\Facades\DB::raw("(employee_id || ' - ' || employee_name) employee_name"), 'employee_id')
                ->where('status', 1)
                ->orderby(DB::raw('EMP_SENIORITY_ORDER(employee_id)'))
                ->pluck('employee_name', 'employee_id');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }


    public function index()
    {
        // $user = auth()->user();
        // dd($user);
        /* if (!auth()->user()->can('User Management'))
             abort(403);
         $users = $this->__filter($request);
         $roles = Role::pluck('name', 'name');
         return view("User::system.index", compact('users', 'roles'));*/

        $user = auth()->user();
        return view("User::index", compact('user'));
        //
        //dd($user);
        // return view("User::index", compact('user'));
    }

    /**
     * This function is liable for User searching Filter
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function __filter($request)
    {
        $user = User::query();
        $user->where('type', 'system');

        if ($request->filled('name')) {
            $user->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('mobile_no')) {
            $user->where('mobile_no', 'like', '%' . $request->mobile_no . '%');
        }
        if ($request->filled('email')) {
            $user->where('email', 'like', '%' . $request->email . '%');
        }

        return $user->orderBy('id', 'desc')->paginate(20);
    }

    /*public function store(Request $request) {

        if (!auth()->user()->can('User Management'))
            abort(403);

        $this->validate($request, [
            'name' => 'required|string|min:3',
            'mobile_no' => 'required|string|min:11|max:14',
            'email' => 'sometimes|nullable|email',
            'password' => 'required|confirmed|min:5',
            'role' => 'required|exists:roles,name'
        ]);
        $validPhoneNumber = mobileNoValidate($request->mobile_no,'local');
        if (!$validPhoneNumber) {
            return redirect()->back()->withErrors('Invalid Mobile Number No')->withInput();
        }
        if (unique_mobile_no_check($request->mobile_no, 'system')) {
            return redirect()->back()->withErrors(__('validation.unique', ['attribute' => 'Mobile No']))->withInput();
        }

        if ($request->filled('email')) {
            if (unique_email_check($request->email, 'system')) {
                return redirect()->back()->withErrors(__('validation.unique', ['attribute' => 'Email']))->withInput();
            }
        }

        try {
            DB::begintransaction();

            $user = new User();
            $user->name = $request->name;
            $user->mobile_no = $request->mobile_no;
            $user->email = $request->email;
            $user->type = 'system';
            $user->password = Hash::make($request->password);
            $user->created_at = Carbon::now();
            $user->save();

            $user->assignRole($request->role);

            DB::commit();

            return redirect()->back()->with("success", "User Create Successfully");
        } catch (Exception $ex) {
            Log::error($ex);
            DB::rollback();
            return redirect()->back()->withErrors("Internal Server Error")->withInput();
        }
    }*/

    /**
     * This function is liable for Storing a user
     * Functionality Not Tested
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (Hash::check($request->current_password, auth()->user()->password) == true) {
            $user->password = Hash::make($request->password);
            $user->password_changed_at = Carbon::now();
            $user->save();
            return Redirect()->to('home')->with('msg-success', 'Password successfully changed');
        } else {
            return Redirect()->back()->with('msg-error', 'Password did not match');
        }
    }

    /**
     * This function is liable for updating a user
     * Functionality Not Tested
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {
        if (!auth()->user()->can('User Management'))
            abort(403);

        $this->validate($request, [
            'name' => 'required|string|min:3',
            'mobile_no' => 'required|string|min:11|max:14',
            'email' => 'sometimes|nullable|email',
            'role' => 'required|exists:roles,name'
        ]);
        $validPhoneNumber = mobileNoValidate($request->mobile_no, 'local');
        if (!$validPhoneNumber) {
            return redirect()->back()->withErrors('Invalid Mobile Number No')->withInput();
        }
        if (unique_mobile_no_check($request->mobile_no, 'system', $id)) {
            return redirect()->back()->withErrors(__('validation.unique', ['attribute' => 'Mobile No']))->withInput();
        }

        if ($request->filled('email')) {
            if (unique_email_check($request->email, 'system', $id)) {
                return redirect()->back()->withErrors(__('validation.unique', ['attribute' => 'Email']))->withInput();
            }
        }

        try {
            DB::begintransaction();
            $user = User::where('type', 'system')->findOrFail($id);
            $user->name = $request->name;
            $user->mobile_no = $request->mobile_no;
            $user->email = $request->email;
            $user->save();

            $user->syncRoles([$request->role]);
            DB::commit();

            return redirect()->back()->with("success", "User Successfully Updated");
        } catch (Exception $ex) {
            Log::error($ex);
            DB::rollback();
            return redirect()->back()->withErrors("Internal Server Error")->withInput();
        }
    }

    /**
     * This function is Implemented to Delete a user
     * Function Not tested
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('User Management'))
            abort(403);

        try {
            User::where('id', $id)->where('type', 'system')->delete();

            return redirect()->back()->with("success", "User Successfully Deleted");
        } catch (Exception $ex) {
            Log::error($ex);
            return redirect()->back()->withErrors("Internal Server Error");
        }
    }

    /**
     * Password Change Section
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changePassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);

        $user = auth()->user();

        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->password_changed_at = Carbon::now();

            $user->save();

            return redirect()->to('home')->with('success', "Password successfully changed");
        } else {

            return redirect()->back()->withErrors("Password did not match");
        }

    }

    /**
     * Forget Password Section Not fully Implemented
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgetPassword(Request $request)
    {
        $user = auth()->user();
        $passwordRequest = new ForgetPasswordRequests();

        if ($request->employee_id == auth()->user()->employee_id) {
            $passwordRequest->employee_id = $request->employee_id;
            $passwordRequest->ip_address = $_SERVER['REMOTE_ADDR'];;
            $passwordRequest->request_time = Carbon::now();
            $passwordRequest->save();

            //return Redirect()->to('home')->with('success', "Password successfully changed");
            return Redirect()->to('login')->with('msg-success', 'Password Change Request Accepted');
        } else {
            return Redirect()->back()->with('msg-error', 'Password Change Request Failed');
        }
    }

    /**
     * This controller is required for no password login
     * SINGLE SIGN ON (SSO)
     * @param $employee_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function empIdLogin($employee_id)
    {
        $secret = "XxOx*4e!hQqG5b~9a";
        $key = urlencode($employee_id);

        $key = strtr(urldecode($key), '-_,', '+/=');

        $var = new EncryptDecrypt;

        try {
            $decrypted = $var->decr($key, $secret);
            $user = User::where('employee_id', $decrypted)->first();
            if ($user) {
                Auth::login($user);
                LoginActivity::create([
                    'username' => $decrypted,
                    'user_ip' => $_SERVER['REMOTE_ADDR'],
                    'purpose' => 'Login',
                    'login_date' => Carbon::now()
                ]);
                return redirect()->route('home');
            } else {
                return redirect()->back();
            }
        } catch (Exception $e) {
            dd($e);
        }


    }
    public function pass_reset_index()
    {
        $_SESSION["MenuActive"] = "settings";
        $_SESSION["MenuActive"] = "PasswordReset";
        $employeeList = $this->allEmployees();

        return view('User::reset/index', compact('employeeList'));

    }
    public function pass_reset_store(Request $request)
    {
        $employee_id=$request->employee_id;
        $employee_pass=$request->password;
        $employee_name=$request->employee_name;
        $user=User::where('EMPLOYEE_ID',$employee_id)->first();

        $user->password = Hash::make($employee_pass);
        $user->password_changed_at = Carbon::now();
        $user->save();
        return redirect()->back()->with('msg-success', $employee_name . ' User Password successfully changed');


    }



}





