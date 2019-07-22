<?php

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NoteCreateRequest
 * @package App\Http\Requests\Note
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
		return [];
	}

	public function messages()
	{
		return [
			'text' => [
				'required',
			],
			'subject_id' => [
				'required',
			],
		];
	}
}
