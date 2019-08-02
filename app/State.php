<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class State
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class State extends Model
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
	protected $table = 'states';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "STATE";

	/**
	 * Define the relationships for States/Countries
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function country()
	{
		return $this->belongsTo('App\\Country');
	}

    public function getManageRouteAttribute()
    {
        return route('eac.portal.settings.manage.states.edit', $this->id);
    }
}
