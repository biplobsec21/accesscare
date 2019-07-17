<?php

namespace App\Traits;

/**
 * Trait GeneratesStrings
 *
 * @package App\Support\Traits
 */
trait GenerateIDTraits
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
  protected static function run($length)
  {
    $str = '';
    for ($i = 0; $i < $length; $i++) {
      $str .= self::$chars[random_int(0, strlen(self::$chars) - 1)];
    }
    return $str;
  }

  /**
   * Generate random string with prefix then validate unique to the DB
   *
   * @param string $model
   * @return string The generated string
   */
  public static function generateWithPrefixUnique(string $model): string
  {
    $generated = self::run(self::$len - strlen(($model::getTablePrefix())));
    $generatedWithPrefix = $model::getTablePrefix() . $generated;
    $result = $model::where(self::$col, '=', $generatedWithPrefix);

    if ($result->count()) {
      return self::generateWithPrefixUnique($model);
    }
    return $generatedWithPrefix;
  }
  public static function newID(string $model = null)
  {
    return GenerateID::generateWithPrefixUnique($model);
  }
}
