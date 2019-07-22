<?php

namespace App\Http\Controllers\Auth;

use App\Address;
use App\Http\Controllers\Controller;
use App\Phone;
use App\Role;
use App\Traits\Hashable;
use App\User;
use App\Permission;
use App\UserType;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\User\UserRegisterRequest;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers, Hashable;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/portal/dashboard';

	/**
	 * UserRegisterRequest a new user instance after a valid registration.
	 *
	 * @param  UserRegisterRequest $request
	 * @return \App\User
	 */
	protected function store(UserRegisterRequest $request)
	{
		$address = new Address();
		$user = new User();

		$user->id = $this->newID(User::class);

		/*
		 * Fill user data
		 */
		$user->title = $request->input('title') ?? null;
		$user->status = 'Registering';
		$user->type_id = UserType::where('name', 'Physician')->firstOrFail()->id;
		$user->first_name = $request->input('first_name');
		$user->last_name = $request->input('last_name');
		$user->email = $request->input('email');
		$user->password = \Hash::make($user->id);
		$user->hospital = $request->input('hospital') ?? null;

		/*
		 * Fill address data
		 */
		$user->address_id = $address->id = $this->newID(Address::class);
		$address->addr1 = $request->input('addr1');
		$address->addr2 = $request->input('addr2');
		$address->city = $request->input('city');
		$address->zipcode = $request->input('zipcode');
		$address->state_province = $request->input('state');
		$address->country_id = $request->input('country');

		/*
		 * Fill phone data
		 */
		if ($request->input('phone')) {
			$phone = new Phone();
			$phone->id = $this->newID(Phone::class);
			$phone->country_id = $request->input('country');
			$phone->number = $request->input('phone');
			$phone->is_primary = true;
			$user->phone_id = $phone->id;
			$phone->save();
		} else {
			$user->phone_id = 0;
		}

		$user->save();
		$address->save();

		\Auth::loginUsingId($user->id);
		return redirect()->route('eac.portal.getDashboard', $user->id);
	}

	/**
	 * CreateRequest a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}
}
