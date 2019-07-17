<?php

namespace App\Http\Requests\Document;

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
			'drug_id' => [
				'required_without:rid_id',
			],
			'rid_id' => [
				'required_without:drug_id',
			],
			'type_id' => [
				'required',
			],
		];
	}

	public function messages()
	{
		return [
			'type_id' => 'This is a required field.',
		];
	}
}
