<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * Class DrugUser
 * @package EAC
 * @author Andrew Mellor <andrew@quasars.com>
 */
class CompanyGroup extends Pivot {


	/**
	 * Indicates if the model should automatically increment the id
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * The event map for the model.
	 * @var array
	 */
	protected $dispatchesEvents = ['saved' => \App\Events\ChangeLogEvent::class,];

	/**
	 * Indicates if the model should be timestamped.
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * The table associated with the model.
	 * @var string
	 */
	protected $table = 'company_user_group';

	/**
	 * Relation for Company
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function company() {
		return $this->belongsTo('App\\Company');
	}

	/**
	 * Relation for user groups
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function user_group() {
		return $this->belongsTo('App\\UserGroup');
	}
}
