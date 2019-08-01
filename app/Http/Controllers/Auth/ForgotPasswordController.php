<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\Notifier;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use Notifier;
    /**
     * CreateRequest a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgotPassword()
    {
        return view('auth.passwords.forgot');
    }

    public function recoverPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
            'email' => 'required|max:40|email',
        ], [
                'email.required' => ' Email Field is Required',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->with("errors", $validator->errors())
                ->withInput();
        } else {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                $validator->getMessageBag()->add('email', 'Email address does not exist');
                return redirect()->back()
                    ->with("errors", $validator->errors())
                    ->withInput();
            }
            $new_password = self::newID('null');
            $user->password_temp = 1;
            $user->password = \Hash::make($new_password);
            $user->save();

            $this->sendMail('password_reset', $new_password, $user);
            return redirect()->back()
                ->with("alert", ['type' => 'success', 'msg' => "A temporary password is sent to your email address"]);
        }
    }
}
