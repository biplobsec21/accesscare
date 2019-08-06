<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class RidShipping
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidShipment extends Model
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
	protected $table = 'rid_shipments';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "SHIPMENT";

    public function getViewRouteAttribute()
    {
        return route('eac.portal.rid.show', $this->rid->id);
    }

	/*
	 * Relation for rid
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function rid()
	{
		return $this->belongsTo('App\\Rid');
	}


	/*
	 * Relation for courier
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function courier()
	{
		return $this->belongsTo('App\\ShippingCourier');
	}

	/*
	 * Relation for depot
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function depot()
	{
		return $this->belongsTo('App\\Depot');
	}

	/*
	 * Relation for pharmacy
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function pharmacy()
	{
		return $this->belongsTo('App\\Pharmacy');
	}

	/*
	 * Relation for pharmacist
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function pharmacist()
	{
		return $this->belongsTo('App\\Pharmacist');
	}

	/*
	 * Add relationship for rids to regimen
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function regimen()
	{
		return $this->hasMany('App\\RidRegimen', 'shipment_id');
	}

	public function visits()
	{
		return $this->hasMany('App\\RidVisit', 'shipment_id');
	}

	public function getTodo()
	{
		$todo = collect([]);
		if (!isset($this->pharmacy))
			$todo->push('Add a pharmacy');
		if (!isset($this->pharmacist))
			$todo->push('Add a pharmacist');
		if ($this->regimensNeeded()->count())
			$todo->push('Add a regimen');
		if (!($this->ship_by_date && $this->deliver_by_date && $this->courier_id))
			$todo->push('Add Shipping Details');

		if($todo->isEmpty())
			$todo='Ready';

		return $todo;
	}

	public function regimensNeeded()
	{
		$components = collect([]);
		foreach ($this->rid->drug->components as $key => $component) {
			if (!$this->regimenWithComponent($component->id))
				$components->push($key);
		}

		return $components;
	}

	public function regimenWithComponent($component_id)
	{
		foreach ($this->regimen as $regimen) {
			if (!$regimen->lot)
				return false;
			if ($regimen->lot->dosage->component->id == $component_id)
				return $regimen;
		}

		return false;
	}
}
