<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Document
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidDocument extends Model
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
	protected $table = 'rid_documents';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "DOCUMENT";

	public function visit()
	{
		return $this->belongsTo('App\\RidVisit', 'visit_id');
	}

	public function drugDocument()
	{
		return $this->belongsTo('App\\DrugDocument', 'drug_doc_id');
	}

	public function type()
	{
		return $this->belongsTo("App\\DocumentType");
	}

	public function template()
	{
		return $this->belongsTo('App\\File', 'template_file_id');
	}

	public function file()
	{
		return $this->belongsTo('App\\File', 'file_id');
	}

	public function redacted()
	{
		return $this->belongsTo('App\\File', 'redacted_file_id');
	}

	public function required()
	{
		if ($this->visit->index == 1 && $this->is_required)
			return true;
		else if ($this->visit->index != 1 && $this->is_required_resupply)
			return true;
		else
			return false;
	}
}
