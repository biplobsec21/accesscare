<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserCreateRequest
 * @package App\Http\Requests
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class UserRegisterRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'first_name' => [
				'required',
			],
			'last_name' => [
				'required',
			],
			'addr1' => [
				'required',
			],
			'city' => [
				'required',
			],
			'zipcode' => [
				'required',
			],
			'email' => [
				'required',
				'max:75',
				'email',
				'unique:mysql.users,email',
			],
			'country' => [
				'required',
			],
			'hospital' => [
				'required',
			],
			'phone' => [
				'required',
			],
		];
	}

	public function messages()
	{
		return [
			'first_name.required' => 'The User\'s first name is required.',

			'last_name.required' => 'The User\'s last name is required.',

			'addr1.required' => 'The address line 1 field is required.',

			'hospital.required' => 'The hospital field is required.',

			'city.required' => 'The city field is required.',

			'zipcode.required' => 'The zipcode field is required.',

			'email.required' => 'The email field is required.',
			'email.max' => 'The email cannot be longer than 75 characters.',
			'email.email' => 'The email must be a valid email format. John.Doe@example.com',
			'email.unique' => 'The email is already taken.',

			'phone.required' => 'The phone number field is required.',

			'country.required' => 'Please select a country.',
		];
	}
}
