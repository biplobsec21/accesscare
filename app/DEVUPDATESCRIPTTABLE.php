<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class DEVUPDATESCRIPTTABLE
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DEVUPDATESCRIPTTABLE extends Model
{


	/**
	 * Indicates if the model should automatically increment the id
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * The event map for the model.
	 *
	 * @var array
	 */
	protected $dispatchesEvents = [
		'saved' => \App\Events\ChangeLogEvent::class,
	];
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'DO_NOT_TOUCH_DEV_UPDATE_SCRIPT_TABLE_DO_NOT_TOUCH';
}
