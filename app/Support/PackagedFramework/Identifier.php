<?php

namespace App\Support;

/**
 * id Helper Functions
 */
class Identifier
{

	/**
	 * @var string Entire Alphabet and Numbers
	 */
	protected static $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

	protected static $len = 30;

	protected static $col = 'id';

	/*
	 * Generate a random string
	 *
	 * @param int $len The length of the desired string
	 * @return string The generated string
	 */
	public static function newID($length)
	{
		$str = '';
		for ($i = 0; $i < $length; $i++) {
			$str .= self::$chars[random_int(0, strlen(self::$chars) - 1)];
		}
		return $str;
	}
}
