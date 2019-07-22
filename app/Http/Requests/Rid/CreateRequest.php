<?php

namespace App\Http\Requests\Rid;

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
		$rules = [
			'physician_id' => [
				'required',
			],
			// 'req_date' => [
			// 	'required',
			// ],
			'drug_id' => [
				'required',
			],
			'patient_gender' => [
				'required',
			],
			// 'patient_country_id' => [
			// 	'required',
			// ],
			// 'pharmacist_name' => [
			// 	'required_without:pharmacist_unknown',
			// ],
			// 'pharmacy_id' => [
			// 	'required_without:pharmacy_unknown',
			// ],
			// 'pharmacy_name' => [
			// 	'required_if:pharmacy_id,new',
			// ],
			// 'pharmacy_addr1' => [
			// 	'required_if:pharmacy_id,new',
			// ],
			// 'pharmacy_country_id' => [
			// 	'required_if:pharmacy_id,new',
			// ],
			// 'pharmacy_city' => [
			// 	'required_if:pharmacy_id,new',
			// ],
			// 'pharmacy_zip' => [
			// 	'required_if:pharmacy_id,new',
			// ],
			'reason' => [
				'required',
			],
			// 'pharmacist_phone' => [
			// 	'required_without:pharmacist_unknown',
			// ],
		];
		$rules['patient_dob.day'] = ['required'];
		$rules['patient_dob.month'] = ['required'];
		$rules['patient_dob.year'] = ['required'];
		return $rules;
	}

	public function messages()
	{
		return [
			'physician_id.required' => 'Selecting a Physician is Required',
			'req_date.required' => 'Entering a Requested Delivery Date is Required',
			'patient_dob.day.required' => 'Entering your Patient\'s Full Date of Birth is Required',
			'patient_dob.month.required' => 'Entering your Patient\'s Full Date of Birth is Required',
			'patient_dob.year.required' => 'Entering your Patient\'s Full Date of Birth is Required',
			'drug_id.required' => 'Selecting a Drug is Required',
			'reason.required' => 'This is a Required Field',
			'proposed_treatment_plan.required' => 'This is a Required Field',
		];
	}
}
