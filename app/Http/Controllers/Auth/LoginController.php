<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;

class LoginController extends Controller
{
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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
	 * Handle a login request to the application.
	 *
	 * @param  Illuminate\Http\Request  $request
	 * @param  App\Repositories\UserRepository  $userRepository
	 * @return Response
	 */
	public function postLogin(
		Request $request,
        UserRepository $userRepository
    )
	{
        // create the validator rules.
        $validator = Validator::make($request->all(), [
            'emailOrLoginId'    => 'required',
            'password'          => 'required'
        ]);
        // we will check validation input parameters.
        if ($validator->fails())
        {
            return redirect("login")->withErrors($validator)->withInput();
        }
        $email = $request->get('emailOrLoginId');
        Log::info('Login user:' . $email);
        // get the user info by email or login id.
        $userInfo = $userRepository->getByEmailOrLoginId($email);
        // we will check the user info.
        if($userInfo == null) {
            return redirect("login")->withErrors(['login' => "User doesn't match"])->withInput();
        }
        // we will check the user role.
        if($userInfo->user_role != 0) {
            return redirect("login")->withErrors(['login' => "Username is not admin "])->withInput();
        }
        $password = $request->get('password');
        // we will check the password.
        if (Hash::check($password, $userInfo->password))
        {
            // save login info to sesstion
            SessionManager::setLoginInfo($userInfo->toArray());
            return redirect('/');                    
        }
        return redirect("login")->withErrors(['login' => "Username or password doesn't match"])->withInput();
	}
}
