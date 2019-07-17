<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Populated implements Rule
{

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string $attribute
	 * @param  array $array
	 * @return bool
	 */
	public function passes($attribute, $array)
	{
		if (in_array(null, $array))
			return false;
		else
			return true;

	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return 'The validation error message.';
	}
}
