<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Note
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidSubStatus extends Model
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
	public $timestamps = true;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'rid_sub_statuses';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "SUBSTATUS";

	public function status()
	{
		return $this->belongsTo('App\\RidStatus');
	}
}
