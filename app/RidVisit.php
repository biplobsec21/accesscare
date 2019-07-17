<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Support\GenerateID;

/**
 * Class Rid
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class RidVisit extends Model
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
	protected $table = 'rid_records';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "RidVisit";

	public function getViewRouteAttribute()
	{
		return route('eac.portal.rid.show', $this->rid->id);
	}
	public function getEditRouteAttribute()
	{
		return route('eac.portal.rid.visit.edit', $this->id);
	}

	/**
	 */
	public function rid()
	{
		return $this->belongsTo('App\\Rid', 'parent_id');
	}

	/**
	 * Add relationship for rids to shipment
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function shipment()
	{
		return $this->belongsTo('App\\RidShipment');
	}

	/**
	 * Relation for physician
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function physician()
	{
		return $this->belongsTo('App\\User', 'physician_id');
	}

	/**
	 * Relation for RidStatus
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function status()
	{
		return $this->belongsTo('App\\RidStatus', 'status_id');
	}

	/**
	 * Relation for RidSubStatus
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function subStatus()
	{
		return $this->belongsTo('App\\RidSubStatus', 'sub_status');
	}

	/**
	 * Relation for documents
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function documents()
	{
		return $this->hasMany('App\\RidDocument', 'visit_id');
	}

	/**
	 * Get required documents, for this visit
	 */
	public function loadDocs()
	{
		if($this->documents->count() > 0)
			return;
		foreach($this->rid->drug->activeDocuments as $drugDoc) {
			$doc = new RidDocument();
			$doc->id = GenerateID::run(10);
			$doc->visit_id = $this->id;
			$doc->drug_doc_id = $drugDoc->id;
			$doc->type_id = $drugDoc->type_id;
			$doc->template_file_id = $drugDoc->file_id;
			$doc->is_required = $drugDoc->is_required;
			$doc->is_required_resupply = $drugDoc->is_required_resupply;
			$doc->save();
		}
	}

	/**
	 * Get required documents, for this visit
	 */
	public function requiredDocs()
	{
		$ridDocs = $this->documents;
		if ($this->index == 1) {
			$ridDocs = $ridDocs->where('is_required', 1);
		} elseif ($this->index != 1) {
			$ridDocs = $ridDocs->where('is_required_resupply', 1);
		}
		return $ridDocs;
	}

	/**
	 * Get all documents that have an uploaded file, for this visit
	 *
	 */
	public function uploadedDocuments()
	{
		return $this->documents->where('file_id', '!=', null) ?? collect([]);
	}

	/**
	 * Do all required docs have an uploaded file?
	 *
	 * @return bool
	 */
	public function getDocStatus()
	{
		$requiredDocs = $this->requiredDocs();
		foreach ($requiredDocs as $requiredDoc) {
			if (!$requiredDoc->file_id) {
				return false;
			}
		}
		return true;
	}

	/*
	 * Get document with drug_doc_id
	 *
	 * @param $drug_doc_id the id to find with
	 */
	public function ridDocument($drug_doc_id)
	{
		return $this->documents->where('drug_doc_id', $drug_doc_id)->first();
	}

	/*
	 * Get the regimen of specified component
	 *
	 * @param $component_id the index of this component
	 */
	public function componentRegimen($component_id)
	{
		return \App\RidRegimen::where('shipment_id', '=', $this->shipment->id)
			->where('visit_id', $this->id)
			->where('component_id', $component_id)->first();
	}



	public function componentRegimen__($component_id, $visit_id)
	{
		// dd($visit_id);
		// return $this->belongsTo('App\\RidRegimen',$this->shipment->id, $component_id);
		return \App\RidRegimen::where('shipment_id', '=', $this->shipment->id)
			->where('visit_id', '=', $visit_id)
			->where('component_id', '=', $component_id)->first();

	}

	public function setIndex()
	{
		$visits = $this->parent->visits->sortBy('created_at')->values();
		$index = $visits->search(function ($visit) {
			return $visit->id === $this->id;
		});
		$this->index = $index + 1;
		$this->save();
	}

	/**
	 * Relation for parent
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function parent()
	{
		return $this->belongsTo('App\\Rid', 'parent_id');
	}

	public function getNotesAttribute()
	{
		if(\Auth::user()->type->name !== 'Physician')
			return $this->all_notes;
		else
			return $this->all_notes->where('physican_viewable', '1');
	}

	/**
	 * Relation for notes
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function all_notes()
	{
		return $this->hasMany('App\\Note', 'subject_id');
	}

	public function hasUser($id)
	{
		return $this->parent->hasUser($id);
	}

	public function hasUserWhereInherited($id)
	{
		return $this->parent->hasUserWhereInherited($id);
	}

	public function hasUserWhereNotInherited($id)
	{
		return $this->parent->hasUserWhereNotInherited($id);
	}

	/**
	 * Relation for pharmacy
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function pharmacy()
	{
		return $this->belongsTo('App\\Pharmacy', 'pharmacy_id');
	}
}
