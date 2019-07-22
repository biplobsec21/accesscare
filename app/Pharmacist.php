<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Pharmacist
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Pharmacist extends Model
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
	protected $table = 'pharmacists';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "PHARMACIST";

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
	 * Relation for pharmacy
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function pharmacy()
	{
		return $this->belongsTo('App\\Pharmacy');
	}

	/**
	 * Relation for phone
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function getPhone()
	{
		$phoneid = $this->phone;
		return \App\Phone::where('id', $phoneid)->first()->number;
	}
	public function getCountry()
	{
		$phoneid = $this->phone;
		return \App\Phone::where('id', $phoneid)->first()->country_id;
	}
}
