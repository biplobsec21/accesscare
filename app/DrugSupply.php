<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


/**
 * Class DrugSupply
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugSupply extends Model
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
	protected $table = 'drug_supply';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "DrugSupply";

	/**
	 * Relation for Drug
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function drug()
	{
		return $this->belongsTo('App\\Drug');
	}
}
