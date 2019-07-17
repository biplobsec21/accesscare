<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Dosage
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugComponent extends Model
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
	protected $table = 'drug_components';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "COMPONENT";

	public function drug()
	{
		return $this->belongsTo('App\\Drug');
	}

	public function dosages()
	{
		return $this->hasMany('App\\Dosage', 'component_id');
	}
	public function activeDosages() {
        return $this->dosages()->where('active','=', 1);
    }
}
