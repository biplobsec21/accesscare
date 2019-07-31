<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * Class User
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class User extends Authenticatable
{
	use Notifiable;

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
	protected $table = 'users';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "USER";

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id',
		'company_id',
		'first_name',
		'last_name',
		'email',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Overrides the method to ignore the remember token.
	 */
	public function setAttribute($key, $value)
	{
		$isRememberTokenAttribute = $key == $this->getRememberTokenName();
		if (!$isRememberTokenAttribute) {
			parent::setAttribute($key, $value);
		}
	}

	public function hasDefaultPassword()
	{
		if (\Hash::check($this->id, $this->password)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Type relation definition
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function type()
	{
		return $this->belongsTo('App\\UserType');
	}

	public function getViewRouteAttribute()
	{
		return route('eac.portal.user.show', $this->id);
	}

	public function getEditRouteAttribute()
	{
		return route('eac.portal.user.edit', $this->id);
	}

	/**
	 * Get all groups user is in
	 */
	public function groups()
	{
		$allGroups = UserGroup::all();
		$groups = collect([]);
		foreach ($allGroups as $group)
            if ($group->users()->contains('id', $this->id)  || $group->parent_user_id == $this->id )
				$groups->push($group);
		return $groups;
	}

	/**
	 * Get all teams user is in with access to object
	 */
	public function groupsAssignedTo($id, $pivot, $area)
	{
		$allTeams = $this->groups();
		$teams = [];
		foreach ($allTeams as $team) {
			$assignment = $pivot::where('user_group_id', $team->id)
				->where($area . '_id', $id)->first();
			if ($assignment)
				array_push($teams, $team);
		}
		return $teams;
	}

	public function assignedTo()
	{
		$assignments = collect([]);
		foreach ($this->groups() as $group) {
			foreach ($group->rids as $rid) {
				$assignments->push((object)[
					'class' => 'Rid',
					'object' => $rid,
					'role' => $group->roleInTeam($this->id),
					'via' => $group
				]);
			}
			foreach ($group->drugs as $drug) {
				$assignments->push((object)[
					'class' => 'Drug',
					'object' => $drug,
					'role' => $group->roleInTeam($this->id),
					'via' => $group
				]);
			}
		}
		return $assignments;
	}

	public function accessible_drugs()
	{
		$drugs = collect([]);
		foreach ($this->groups() as $group) {
			foreach ($group->drugs as $drug) {
				$drugs->push($drug);
			}
		}
		return $drugs;
	}

	/**
	 * permission relation definition
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\hasOne
	 */
	public function permission()
	{
		return $this->hasOne('App\\Permission');
	}

	public function rids()
	{
		return $this->hasMany('App\\Rid', 'physician_id');
	}

	/**
	 * Get all groups user is in
	 */
	public function groups_leading()
	{
		return $this->hasMany('App\\UserGroup', 'parent_user_id');
	}

	/**
	 * Address relation definition
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function address()
	{
		return $this->belongsTo('App\\Address');
	}

	/**
	 * Company relation definition
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function company()
	{
		return $this->belongsTo('App\\Company');
	}

	/**
	 * Relation for notes
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function notes()
	{
		return $this->hasMany('App\\Note', 'subject_id');
	}

	/**
	 * Relation for notifications
	 */
	public function notifications()
	{
		return Notification::where('user_id', $this->id)->orderBy('created_at', 'desc')->take(20)->get();
	}

	/**
	 * Relation for phones
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function phone()
	{
		return $this->belongsTo('App\\Phone');
	}

	/**
	 * Relation for Certificates
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function certificate()
	{
		return $this->hasOne('App\\UserCertificate');
	}

	/**
	 * Get the user's full name.
	 *
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return "{$this->first_name} {$this->last_name}";
	}

	/**
	 * Make email lowercase
	 *
	 * @param $value
	 */
	public function setEmailAttribute($value)
	{
		$this->attributes['email'] = strtolower($value);
	}

	public function getCountryID()
	{
		try {
			return $this->address->country->id;
		} catch (\Exception $e) {
			return false;
		}
	}

	public static function physicians(){
		$physicians = User::where('type_id', UserType::where('name', 'Physician')->first()->id)->where('status', 'Approved')->get()->filter(function($user, $key){
			if($user->groups_leading->count())
				return $user;
			else
				return false;
		})->sortBy('first_name');
		return $physicians;
	}
}
