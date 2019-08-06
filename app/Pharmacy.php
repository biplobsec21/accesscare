<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Pharmacy
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Pharmacy extends Model
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
	protected $table = 'pharmacies';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "PHARMACY";

    public function getEditRouteAttribute()
    {
        return route('eac.portal.pharmacy.edit', $this->id);
    }

	/**
	 * Relation for address
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function address()
	{
		return $this->belongsTo('App\\Address', 'address_id');
	}

	/**
	 * Relation for physician
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function physician()
	{
		return $this->belongsTo('App\\User');
	}

	/**
	 * Relation for pharmacists
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function pharmacists()
	{
		return $this->hasMany('App\\Pharmacist');
	}
}
