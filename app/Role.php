<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Role
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Role extends Model
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
	protected $table = 'roles';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "ROLE";

	public function users()
	{
		return $this->hasMany('App\User')->using('App\UserType');
	}

	public function type()
	{
		return $this->belongsTo('App\UserType');
	}

	public function can($permission)
	{
		return json_decode($this->base_level, true)[$permission[0]][$permission[1]][$permission[2]] ?? false;
	}

	public function hasArea($area)
	{
		$level = json_decode($this->base_level, true);
		if(!$sections = $level[$area] ?? false)
			return false;
		else
			return $level;
	}

	public function areas()
	{
		return collect(json_decode($this->base_level, true))->keys();
	}

	public static function default_level()
	{
		return json_decode(Role::where('name', 'Default')->first()->base_level);
	}
}
