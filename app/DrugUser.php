<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class DrugUser
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugUser extends Model
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
	protected $table = 'drug_users';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "DRUGUSER";

	/**
	 * Relation for users
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function user()
	{
		return $this->belongsTo('App\\User');
	}

	/**
	 * Relation for role
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function role()
	{
		return $this->belongsTo('App\\Role');
	}

	/**
	 * Relation for drugs
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function drug()
	{
		return $this->belongsTo('App\\Drug');
	}

	public function permissionLevel()
	{
		$arr = json_decode($this->level, true);
		return $arr;
	}

	public function roleIsInherited()
	{
		$level = json_decode($this->level, true);
		if ($level == 'Inherited')
			return true;
		else
			return false;
	}

	public function getRole()
	{
		try {
		if ($this->roleIsInherited())
			if($this->user->role)
				return $this->user->role->name . " (Inherited)";
			else
				return false;
		else
			if (!$this->role_id)
				return false;
			else
				if ($this->user->role_id == $this->role_id)
					return $this->role->name . " (Explicit)";
				else
					return $this->role->name;
		}
		catch (\Exception $e){
			return false;
		}
	}
}
