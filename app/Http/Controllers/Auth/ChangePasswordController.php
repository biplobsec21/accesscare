<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $rules = [
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if(!Hash::check($value, \Auth::user()->password)) {
                    $fail('Current Password Incorrect.');
                }
            }],
            'new_password' => ['required', 'min:8'],
        ];
        $messages = [
            'current_password.required' => 'Current Password Required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->with("errors", $validator->errors())
                ->withInput();
        }

        $user = \Auth::user();

        $user->password = \Hash::make($request->input('new_password'));
        $user->save();
        return redirect()->route('eac.portal.getDashboard')->with('confirm', 'Password Has Been Changed.');

    }
}
