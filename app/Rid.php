<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

/**
 * Class Rid
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Rid extends Model
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
	protected $table = 'rids';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "RID";

	public function getViewRouteAttribute()
	{
		return route('eac.portal.rid.show', $this->id);
	}

	public function getEditRouteAttribute()
	{
		return route('eac.portal.rid.edit', $this->id);
	}


	public function getNameAttribute()
	{
		return "{$this->number}";
	}

	/**
	 * Add relationship for rids to drugs
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function drug()
	{
		return $this->belongsTo('App\\Drug');
	}

	/**
	 * Add relationship for rids to regimen
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
	 */
	public function regimen()
	{
		return $this->hasManyThrough(
			'App\\RidRegimen',
			'App\\RidShipment',
			'rid_id',
			'id',
			'id',
			'shipment_id'
		);
	}

	/**
	 * Relation for physician
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function physician()
	{
		return $this->belongsTo('App\\User', 'physician_id');
	}

	/**
	 * Relation for RidStatus
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function status()
	{
		return $this->belongsTo('App\\RidMasterStatus', 'status_id');
	}

	/**
	 * Relation for children
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function visits()
	{
		return $this->hasMany('App\\RidVisit', 'parent_id');
	}

	public function last_visit() {
		return RidVisit::where('parent_id', $this->id)->latest()->first();
	}

	public function getNotesAttribute()
	{
		if(\Auth::user()->type->name !== 'Physician')
			return $this->all_notes;
		else
			return $this->all_notes->where('physican_viewable', '1');
	}

	/**
	 * Relation for notes
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function all_notes()
	{
		return $this->hasMany('App\\Note', 'subject_id');
	}
	/**
	 * Relation for User Groups
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function user_groups()
	{
		return $this->belongsToMany('App\\UserGroup')
			->using('App\\RidGroup')
			->withPivot('id');
	}

	/**
	 * Relation for shipment
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function shipments()
	{
		return $this->hasMany('App\\RidShipment');
	}

	public function shipmentsSorted () {
		return $this->shipments->sortBy(function ($ship, $key) {
			return $ship->visits->min('index');
		});
	}

	/**
	 * Get the rid patient gender
	 *
	 * @return string
	 */
	public function getPatientGenderAttribute($value)
	{
		return ucfirst($value);
	}

	public function getPatientAge()
	{
		return Carbon::parse($this->attributes['patient_dob'])->age;
	}

	public function patient_country()
	{
		return $this->belongsTo('App\\Country', 'patient_country_id');
	}
	public function ethnicity()
	{
		return $this->belongsTo('App\\Ethnicity', 'patient_ethnicity');
	}
}
