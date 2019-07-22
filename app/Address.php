<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Address extends Model
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
	protected $table = 'addresses';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "ADDRESS";

	public function state()
	{
		// return $this->belongsTo('App\\State');
		return $this->belongsTo('App\\State', 'state_province');
	}

	public function country()
	{
		return $this->belongsTo('App\\Country');
	}

	public function strDisplayShort()
	{
		$str = $this->addr1 . '</br>';
		if ($this->addr2)
			$str .= $this->addr2 . '</br>';
		$str .= $this->city . ' ';
		if ($this->state_province)
			$str .= ( $this->state->abbr ?? $this->state_province ) . ' ';
		$str .= $this->zipcode;
		return $str;
	}

	public function strDisplay()
	{
		return $this->strDisplayShort() . ' ' . ($this->country->name ?? '');
	}
}
