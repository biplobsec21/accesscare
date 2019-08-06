<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class RidShipping
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Depot extends Model
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
	protected $table = 'depots';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "DEPOT";

    public function getEditRouteAttribute()
    {
        return route('eac.portal.depot.edit', $this->id);
    }

	public function address()
	{
		return $this->belongsTo('App\Address');
	}

	public function lots()
	{
		return $this->hasMany('App\DrugLot');
	}

	public function lotsWithDrug($drug_id)
	{
		$lots = collect();
		foreach ($this->lots as $lot) {
			if ($lot->drug())
				if ($lot->drug()->id == $drug_id)
				$lots->push($lot);
		}
		if(!$lots->count())
			return 0;
		return $lots;
	}

	public static function allWithDrug($drug_id)
	{
		$depots = collect();
		foreach (Depot::all() as $depot) {
			$lots = $depot->lotsWithDrug($drug_id);
			if ($lots) {
				$depot->relations['lots'] = $lots;
				$depots->push($depot);
			}
		}
		return $depots;
	}
}
