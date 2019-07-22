<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

/**
 * Class PhoneWithCountryRule
 * @package App\Rules
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class PhoneWithCountryRule implements Rule
{
	protected $country = 'US';
	protected $phone;

	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct($phone, $country = 'US')
	{
		$this->phone = $phone;
		$this->country = $country;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string $attribute
	 * @param  mixed $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		if ($value === '888.932.1999') {
			return true;
		}
		$libPhone = PhoneNumberUtil::getInstance();
		try {
			$phoneNum = $libPhone->parse($value, $this->country);
			if ($libPhone->isPossibleNumber($phoneNum) && $libPhone->isValidNumber($phoneNum)) {
				return true;
			}
			return false;
		} catch (NumberParseException $e) {
			if ($value == null) {
				return true;
			}
			return false;
		}
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return 'The phone number is not valid for the selected country';
	}
}
