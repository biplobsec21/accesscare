<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Log
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Log extends Model
{
	

	//DO NOT ASSIGN EVENT MAP

	/**
	 * Indicates if the model should automatically increment the id
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'log';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "LOG";
}
