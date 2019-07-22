<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Country
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidPostApprovalDocs extends Model
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
	protected $table = 'rid_post_approval_docs';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "RidPostApprovalDocs";

	public function file()
	{
		return $this->belongsTo('App\\File', 'uploaded_file_id');
	}
}
