<?php

namespace App\Http\Requests\User;

use App\Rules\Concurrent;
use App\Rules\Populated;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserCreateRequest
 * @package App\Http\Requests
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class GroupCreateRequest extends FormRequest
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
			'type_id' => [
				'required',
			],
			'parent_id' => [
				'required',
			],
			'name' => [
				'required',
			],
			'role' => [
				'min:1',
				new Populated(),
			],
			'member' => [
				'min:1',
				new Populated(),
				new Concurrent($this->request->get('role')),
			],
		];
	}

	public function messages()
	{
		return [
			'type_id.required' => 'Group type is required.',
			'parent_id.required' => 'Group leader is required.',
			'name.required' => 'Group name is required.',
		];
	}
}
