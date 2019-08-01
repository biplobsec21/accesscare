<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
	use ResetsPasswords;

	/**
	 * Where to redirect users after resetting their password.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * CreateRequest a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function changePassword()
    {
        return view('auth.passwords.change');
    }

    public function updatePassword(Request $request)
    {
        if ($request->input('new_password') !== $request->input('confirm_password'))
            return redirect()->back()->with('error', 'Passwords Did Not Match.')->withInput();

        $user = \Auth::user();
        $user->password = \Hash::make($request->input('new_password'));
        $user->save();
        return redirect()->back()->with('confirm', 'Password Has Been Changed.');

    }
}
