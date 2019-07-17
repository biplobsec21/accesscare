<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Concurrent implements Rule
{
	protected $second_array;

	/**
	 * Create a new rule instance.
	 *
	 * @param array $array Array we are checking for concurrency against
	 * @return void
	 */
	public function __construct($array)
	{
		$this->second_array = $array;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string $attribute
	 * @param  array $array
	 * @return bool
	 */
	public function passes($attribute, $array)
	{
		if (count($array) == count($this->second_array))
			return true;
		else
			return false;
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
