<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Role
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Ethnicity extends Model
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
	protected $table = 'ethnicity';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "ETHNICITY";

    public function getEditRouteAttribute()
    {
        return route('eac.portal.settings.manage.ethnicity.edit', $this->id);
    }
}
