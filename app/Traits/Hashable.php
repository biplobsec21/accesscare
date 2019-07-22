<?php

namespace App\Traits;

/**
 * Trait Hashable
 *
 * @package App\Support\Traits
 */
trait Hashable
{
	/**
	 * Make a hash based on the unhashed string
	 *
	 * @param string $unhashed The unhashed string
	 * @return string The created hash
	 */
	protected function makeHash($unhashed)
	{
		$hashed = \Hash::make($unhashed);
		if ($this->checkHash($unhashed, $hashed)) {
			return $hashed;
		}
		return $this->makeHash($unhashed);
	}

	/**
	 * Chack the unhashed string to the hashed string
	 *
	 * @param string $unhashed The unhashed string
	 * @param string $hashed The hashed string
	 * @return bool
	 */
	protected function checkHash($unhashed, $hashed)
	{
		if (\Hash::check($unhashed, $hashed)) {
			return true;
		}
		return false;
	}
}
