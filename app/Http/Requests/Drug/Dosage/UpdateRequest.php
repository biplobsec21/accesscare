<?php

namespace App\Http\Requests\Drug\Dosage;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateRequest
 * @package App\Http\Requests
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class UpdateRequest extends FormRequest
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
			'form_id' => [
				'required',
			],
			'temperature' => [
				'required',
			],
			'amount' => [
				'required',
			],
			'unit_id' => [
				'required',
			],
			'strength_id' => [
				'required',
			],
		];
	}

	public function messages()
	{
		return [
			'form_id.required' => 'Dosage Form field is required',
			'temperature.required' => 'Optimal Temperature field is required',
			'amount.required' => 'Amount field is required',
			'unit_id.required' => 'Unit field is required',
			'strength_id.required' => 'Strength field is required',
		];
	}
}
