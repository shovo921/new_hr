<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use Validator;

use App\Jobs\LoginActivityLog;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function username() {
        return 'employee_id';
    }

    public function showLoginForm() {
        return view('login');
    }

    protected function credentials(Request $request) {
        $data = $request->only($this->username(), 'password');
        $data['type'] = 'system';
        return $data;
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        activity()->useLog($request->employee_id)
                // ->performedOn($request)
                // ->causedBy(auth()->user())
                ->withProperty('employee_id', $request->employee_id)
                ->log('Try User to Login');

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            dispatch(new LoginActivityLog($request, "Login"));

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }



    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {

            dispatch(new LoginActivityLog($request, "Login"));

            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    public function apiLogin(Request $request) {
        $validator = Validator::make($request->all(), [
                    'employee_id' => 'required|string',
                    'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return appApiResponse(422, "The given data was invalid.", $validator->errors(), $data = null);
        }
        try {
            $credentials = request(['employee_id', 'password']);
            $credentials['type'] = 'visitor';
            if (!Auth::attempt($credentials))
                return appApiResponse(401,trans('auth.failed'),null);
            $user = $request->user();
            $token = Str::random(60) . $user->employee_id;
            $user->api_token = $token;
            $user->save();
            return appApiResponse(200, 'Login successful',null,['user' => $user]);
        } catch (\Exception $e) {
            \Log::error($e);
            return appApiResponse(500,__('app.something_went_wrong'),__('app.something_went_wrong'),null);
        }
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        dispatch(new LoginActivityLog($request, "Logout"));

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }


        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

}
