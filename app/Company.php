<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Company
 *
 * @package App
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Company extends Model
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
	protected $table = "companies";

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "COMPANY";

    public function getViewRouteAttribute()
    {
        return route('eac.portal.company.show', $this->id);
    }


    /**
	 * The address relationship definition
	 */
	public function address()
	{
		return $this->belongsTo('App\\Address');
	}

	/**
	 * The departments relationship definition
	 */
	public function department()
	{
		return $this->hasMany('App\\Department');
	}

	/**
	 * The mainPhone relationship definition
	 */
	public function phone()
	{
		return $this->hasOne('App\\Phone','id','phone_main');
	}

	/**
	 * Users relation definition
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function users()
	{
		return $this->hasMany('App\\User');
	}

	public function drugs()
	{
		return $this->hasMany('App\\Drug');
	}

	public function rids()
	{
		return $this->hasManyThrough(
			'App\\Rid',
			'App\\Drug',
			'company_id',
			'drug_id',
			'id',
			'id'
		);
	}

	/**
	 * Relationship for departments
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function departments()
	{
		return $this->hasMany('App\\Department');
	}

	/**
	 * Relationship for user_groups
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function user_groups()
	{
		return $this->belongsToMany('App\\UserGroup')
			->using('App\\CompanyGroup')
			->withPivot('id');
	}
}
