<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Resource
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Resource extends Model
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
	protected $table = 'resources';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "RESOURCE";

	/**
	 * Relation to file
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function file()
	{
		return $this->belongsTo('App\\File');
	}

	/**
	 * Relation to type
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function type()
	{
		return $this->belongsTo('App\\DocumentType');
	}
}
