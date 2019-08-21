<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Note
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Note extends Model
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
	protected $table = 'notes';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "NOTE";

	public function author()
	{
		return $this->belongsTo('App\\User');
	}
	
	public function PhysicianMember(){
		$Members = collect();
		$rid = \App\Rid::where('id',$this->subject_id)->firstOrFail();

		if($rid->user_groups->count() > 0){
			foreach($rid->user_groups as $userGroup){
				if($userGroup->type->name == 'Physician'){
					foreach($userGroup->users() as $user){
						$Members->push($user);
					}
				}
			}
		}
		return $Members;
	}
}
