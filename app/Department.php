<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Departments
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Department extends Model
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
	protected $table = 'departments';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "DEPARTMENT";

	/**
	 * Relation for phone
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function phone()
	{
		return $this->belongsTo('App\\Phone');
	}

	/**
	 * Relationship for email
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function email()
	{
		return $this->belongsTo('App\\Email');
	}

	/**
	 * Relationship for company
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function company()
	{
		return $this->belongsTo('App\\Company');
	}
}
