<?php

namespace App\Http\Requests\Rid\Pharmacy;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateRequest
 * @package App\Http\Requests
 *
 * Andrew Mellor <andrew@quasars.com>
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
			'user_id' => [
				'required',
			],
			'pharmacy_name' => [
				'required',
			],
			'pharmacy_addr1' => [
				'required',
			],
			'pharmacy_city' => [
				'required',
			],
			'pharmacy_zip' => [
				'required',
			],
			
			'pharmacy_country_id' => [
				'required',
			],
		];
	}

	public function messages()
	{
		return [
			'user_id.required' => 'This field is required.',
			'pharmacy_name.required' => 'This field is required.',
			'pharmacy_addr1.required' => 'This field is required.',
			'pharmacy_city.required' => 'This field is required.',
			'pharmacy_zip.required' => 'This field is required.',
			'pharmacy_state_province.required' => 'This field is required.',
			'pharmacy_country_id.required' => 'This field is required.',
		];
	}
}
