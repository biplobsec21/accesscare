<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Traits\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
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
	protected $redirectTo = '/portal/dashboard';

	/**
	 * CreateRequest a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		$this->guard()->logout();

		$request->session()->invalidate();

		return $this->loggedOut($request) ?: redirect('/auth/signin');
	}

	protected function setLastSeen()
	{
		try {
			$user = User::where('id', '=', \Auth::user()->id)->firstOrFail();
			$user->last_seen = Carbon::now();
			$user->saveOrFail();
		} catch (Throwable $throwable) {
			Log::warning("Failed setting 'last_seen' value for user\n" .
				"*Exception Message*\n" .
				"{$throwable->getMessage()} \n" .

				"*File* \n" .
				"{$throwable->getFile()} on line {$throwable->getLine()} \n" .

				"*Trace* \n" .
				"```{$throwable->getTraceAsString()}```` \n" .

				"*UserId* \n" .
				"`" . \Auth::user()->id . "`");
			return;
		}
	}

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return array
	 */
	protected function credentials(Request $request)
	{
		$username = $this->username();
		$credentials = $request->only($username, 'password');
		if (isset($credentials[$username])) {
			$credentials[$username] = strtolower($credentials[$username]);
		}
		return $credentials;
	}
}
