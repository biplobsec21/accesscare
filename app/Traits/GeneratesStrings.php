<?php

namespace App\Traits;

/**
 * Trait GeneratesStrings
 *
 * @package App\Support\Traits
 */
trait GeneratesStrings
{
 /**
  * @var string All Upper Letters
  */
 protected $GENERATESSTRINGS_CHARS_UPPER = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

 /**
  * @var string All Lower Letters
  */
 protected $GENERATESSTRINGS_CHARS_LOWER = "abcdefghijklmnopqrstuvwxyz";

 /**
  * @var string Entire Alphabet
  */
 protected $GENERATESSTRINGS_CHARS_UPPER_LOWER = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

 /**
  * @var string Entire Alphabet and Numbers
  */
 protected $GENERATESSTRINGS_CHARS_UPPER_LOWER_NUM = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

 /**
  * @var string All Upper Letters and Numbers
  */
 protected $GENERATESSTRINGS_CHARS_UPPER_NUM = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

 /**
  * @var string All Lower Letters and Numbers
  */
 protected $GENERATESSTRINGS_CHARS_LOWER_NUM = "abcdefghijklmnopqrstuvwxyz1234567890";

 /**
  * Generate a random string based on the characters and length provided; also ensure the generated value is not in a database
  *
  * @param string $connection The connection to use
  * @param string $table The table to look under
  * @param string $col The coulumn to check
  * @param string $chars The characters that should be in the string
  * @param int $len The length of the desired string
  * @return string The generated string
  */
 protected function generateUnique($connection = 'mysql', $table, $col, $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!@#%", $len = 20)
 {
  $generated = $this->generate($chars, $len);
  $res = \DB::connection($connection)->select("select * from " . $table . " where " . $col . "='" . $generated . "'");
  if ($res) {
   $this->generateUnique($connection, $table, $col, $chars, $len);
  }
  return $generated;
 }

 /**
  * Generate a random string based on the characters and length provided
  *
  * @param string $chars The characters that should be in the string
  * @param int $len The length of the desired string
  * @return string The generated string
  */
 protected function generate($chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890", $len = 20)
 {
  $s = '';
  for ($i = 0; $i < $len; $i++) {
   $s .= $chars[random_int(0, strlen($chars) - 1)];
  }
  return $s;
 }

 /**
  * Generate random string with prefix then validate unique to the DB
  *
  * @param string $col
  * @param string $model
  * @param int $len
  * @param string $chars
  *
  * @return string The generated string
  */
 // protected function generateWithPrefixUnique(string $model, string $col = 'id', int $len = 30, string $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"): string
 // {
 //  $generated = $this->generate($chars, ($len - strlen(($model::getTablePrefix()))));
 //  $generatedWithPrefix = $model::getTablePrefix() . $generated;
 //  $result = $model::where($col, '=', $generatedWithPrefix);

 //  if ($result->count()) {
 //   return $this->generateWithPrefixUnique($model, $col, $len, $chars);
 //  }
 //  return $generatedWithPrefix;
 // }

 /**
  * Generate random string with prefix then validate unique to the DB
  *
  * @param string $connection The connection to use
  * @param string $table The table to look under
  * @param string $col The coulumn to check
  * @param string $prefix The prefix to the generated chars
  * @param string $chars The characters that should be in the string
  * @param int $len Total length of generated string including prefix
  * @return string The generated string
  *
  * @deprecated
  *
  * @see GeneratesStrings::generateWithPrefixUnique()
  */
 protected function generateUniqueWithPrefix(string $connection = 'mysql', string $table, string $col, string $prefix, string $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!@#%", int $len = 20): string
 {
  $genLength = ($len - strlen($prefix));
  $generated = $this->generate($chars, $genLength);
  $result = \DB::connection($connection)->select("select ' . $col . ' from " . $table . " where " . $col . "='" . $generated . "'");

  if ($result) {
   $this->generateUniqueWithPrefix($connection, $table, $col, $prefix, $chars, $len);
  }
  return $prefix . $generated;
 }
 

  /*
   * Generate a random string
   *
   * @param int $len The length of the desired string
   * @return string The generated string
   */
  
  public  function newID($model)
  {

    // $generatedWithPrefix = $model::getTablePrefix().substr(str_shuffle(MD5(microtime())), 0, 10);;
    
    // $result = $model::where('id', '=', $generatedWithPrefix);

    // if ($result->count()) {
    //   return $this->generateWithPrefixUnique($model);
    // }
    // return $generatedWithPrefix;
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $str = '';
    for ($i = 0; $i < 10; $i++) {
      // $str .= self::$chars[random_int(0, strlen(self::$chars) - 1)];
      $str .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $str;
    // return $generatedWithPrefix;
  }
}
