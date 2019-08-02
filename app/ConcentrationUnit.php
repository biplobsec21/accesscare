<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class DosageUnit
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class ConcentrationUnit extends Model
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
	protected $table = 'concentration_units';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "DOSAGEUNITS";

    public function getManageRouteAttribute()
    {
        return route('eac.portal.settings.manage.drug.dosage.concentration.edit', $this->id);
    }
}
