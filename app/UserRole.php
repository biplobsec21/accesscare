<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * Class Role
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class UserRole extends Pivot
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
	protected $table = 'user_roles';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "USERROLE";

	public function role()
	{
		return $this->hasOne('App\Role', 'role_id', 'id');
	}

	public function user()
	{
		return $this->hasOne('App\User', 'user_id', 'id');
	}
}
