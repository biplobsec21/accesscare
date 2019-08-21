<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Notification
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Notification extends Model
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
	protected $table = 'notifications';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "NOTIFICATION";

	public function getSubjectAttribute()
	{
		if(Rid::where('id', $this->subject_id)->first())
			return Rid::where('id', $this->subject_id)->first();
		else if(RidVisit::where('id', $this->subject_id)->first())
			return RidVisit::where('id', $this->subject_id)->first();
		else if(Drug::where('id', $this->subject_id)->first())
			return Drug::where('id', $this->subject_id)->first();
		else if(User::where('id', $this->subject_id)->first())
			return User::where('id', $this->subject_id)->first();
		else if(Note::where('id', $this->subject_id)->first())
			return Note::where('id', $this->subject_id)->first();
	}
}
