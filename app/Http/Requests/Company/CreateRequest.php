<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateRequest
 * @package App\Http\Requests
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class CreateRequest extends FormRequest
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
			'name' => [
				'required',
			],
			'abbr' => [
				'required',
			],
			'addr1' => [
				'required',
			],
			'addr2' => [
			],
			'city' => [
				'required',
			],
			'country' => [
				'required',
			],
			'state' => [
			],
			'zipcode' => [
				'required',
			],
			'phone' => [
				'required',
			],
			'email' => [
				'required',
			],
		];
	}

	public function messages()
	{
		return [
			'name' => 'The company\'s name is required',
			'abbr' => 'The company\'s abbreviation is required',
			'status' => 'The company\'s status is required',
			'phone' => 'The company\'s phone is required',
			'email' => 'The company\'s email is required',
			'website' => 'The company\'s website is required',
			'addr1' => 'The company\'s address is required',
			'city' => 'The company\'s city is required',
			'country' => 'The company\'s country is required',
			'zipcode' => 'The company\'s zipcode is required',
		];
	}
}
