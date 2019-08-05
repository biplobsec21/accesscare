<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class DosageRoute
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DosageRoute extends Model
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
	protected $table = 'dosage_routes';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "DOSAGEROUTE";

    public function getEditRouteAttribute()
    {
        return route('eac.portal.settings.manage.drug.dosage.route.edit', $this->id);
    }
}
