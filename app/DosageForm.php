<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class DosageForm
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DosageForm extends Model
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
	protected $table = 'dosage_forms';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */

    public function getEditRouteAttribute()
    {
        return route('eac.portal.settings.manage.drug.dosage.form.edit', $this->id);
    }

	protected $prefix = "DOSAGEFORM";

	public function route()
	{
		return $this->hasOne('App\\DosageRoute', 'id', 'route_id');
	}
}
