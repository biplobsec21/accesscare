<?php

namespace App\Http\Requests\Rid;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateRequest
 * @package App\Http\Requests
 *
 * Andrew Mellor <andrew@quasars.com>
 */
class ResupplyCreateRequest extends FormRequest
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
			'number_of_visits' => [
				'required',
				'gt:0',
			],
			'first_visit_date' => [
				'required',
				'date',
				'after:today',
			],
			'days_to_deliver' => [
				'required',
				'gt:0',
			],
			'supply_length' => [
				'required',
				'gt:0',
			],
		];
	}

	public function messages()
	{
		return [
			'number_of_visits.required' => 'Entering the Number of Visits is Required',
			'number_of_visits.gt' => 'The Number of Visits must be greater than 0',
			'first_visit_date.required' => 'Entering the First Visit Date is Required',
			'days_to_deliver.required' => 'Entering the Days to Deliver is Required',
			'supply_length.required' => 'Entering the Supply Length is Required',
		];
	}
}
