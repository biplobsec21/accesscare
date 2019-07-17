<?php

namespace App\Http\Requests\Drug;

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
				'min:4',
				'max:200',
			],
			'lab_name' => [
				'required',
				'min:4',
				'max:200',
			],
			'company_id' => [
				'required',
			],
			'desc' => [
				'required',
			],
			'component_main' => [
				'required',
			],
		];
	}

	public function messages()
	{
		return [
			'name.required' => 'The drug name is required.',

			'lab_name.required' => 'The drug lab name is required.',

			'company_id.required' => 'Selecting the manufacturer is required.',

			'component_name.required' => 'Component Name is required.',
		];
	}
}
