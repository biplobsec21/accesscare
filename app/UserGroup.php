<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Role
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class UserGroup extends Model
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
	protected $table = 'user_groups';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "USERGROUP";

	public function parent()
	{
		return $this->belongsTo('App\User', 'parent_user_id');
	}

	public function users()
	{
		$collection = collect([]);
		foreach (json_decode($this->group_members) as $member) {
			$collection->push(User::where('id',$member->id)->first());
		}
		return $collection;
	}

	public function members()
	{
		$collection = json_decode($this->group_members);
		foreach ($collection as $member) {
			$member->user = User::where('id',$member->id)->first();
			$member->role = Role::where('id',$member->role)->first();
		}
		return collect($collection);
	}

	public function roleInTeam($user_id)
	{	
		$collection = json_decode($this->group_members);
		foreach ($collection as $member) {
			if($member->id == $user_id){
				return Role::where('id', $member->role)->first() ?? null;
			}
		}

		// return Role::where('id', json_decode($this->group_members)->{$user_id})->first() ?? null;
	}

	/**
	 * Relation for Rid Assignments
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function rids()
	{
		return $this->belongsToMany('App\\Rid')
			->using('App\\RidGroup')
			->withPivot('id');
	}

	/**
	 * Relation for Drug Assignments
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function drugs()
	{
		return $this->belongsToMany('App\\Drug')
			->using('App\\DrugGroup')
			->withPivot('id');
	}

	/**
	 * Relation for User Type
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function type()
	{
		return $this->belongsTo('App\\UserType', 'type_id');
	}
}
