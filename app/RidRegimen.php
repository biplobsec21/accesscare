<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class RidRegimen
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidRegimen extends Model
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
	protected $table = 'rid_regimens';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "REGIMEN";

	public function lot()
	{
		return $this->belongsTo('App\DrugLot', 'drug_lot_id');
	}

	/*
	 * Get the component of this regimen
	 */
	public function component()
	{
		try {
			return $this->lot->dosage->component;
		} catch (\Exception $e) {
			return 0;
		}
	}

}
