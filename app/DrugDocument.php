<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Document
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DrugDocument extends Model
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
	protected $table = 'drug_documents';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "DOCUMENT";

	public function drug()
	{
		return $this->belongsTo("App\\Drug");
	}

	public function type()
	{
		return $this->belongsTo("App\\DocumentType");
	}

	public function file()
	{
		return $this->belongsTo('App\\File','file_id');
	}
}
