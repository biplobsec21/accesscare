<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class RidShipping
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugLot extends Model
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
	protected $table = 'drug_lots';

    public function getEditRouteAttribute()
    {
        return route('eac.portal.lot.edit', $this->id);
    }

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "LOT";

	public function dosage()
	{
		return $this->belongsTo('App\Dosage');
	}

	public function depot()
	{
		return $this->belongsTo('App\Depot');

	}
	public function drug()
	{
		if ($this->dosage)
			return $this->dosage->component->drug;
		else
			return 0;
	}
	public static function allWithDrug($drug_id)
	{
		$lots = collect();
		foreach (DrugLot::all() as $lot) {
			if($lot->dosage){
				if ($lot->dosage->component->drug->id === $drug_id) {
				$lots->push($lot);
			}
			}

		}
		return $lots;
	}
}
