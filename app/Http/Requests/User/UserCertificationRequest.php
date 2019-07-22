<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserCreateRequest
 * @package App\Http\Requests
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class UserCertificationRequest extends FormRequest
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
			'emergency_register' => [
			],
			'cv_file' => [
				'required_without:emergency_register',
			],
			'license_file' => [
				'required_without:emergency_register',
			],
			'user_signature' => [
				'required',
			],
		];
	}

	public function messages()
	{
		return [
			'cv_file.required_without' => 'This is a required field.',

			'license_file.required_without' => 'This is a required field.',

			'user_signature.required' => 'This is a required field.',
		];
	}
}
