<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Drug
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Drug extends Model
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
	protected $table = 'drug';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "DRUG";

	public function getViewRouteAttribute()
	{
		return route('eac.portal.drug.show', $this->id);
	}
	public function getEditRouteAttribute()
	{
		return route('eac.portal.drug.edit', $this->id);
	}

	public function getDosagesAttribute()
	{
		return $this->components->pluck('dosages')->flatten();
	}

	public function getLotsAttribute()
	{
		return $this->dosages->pluck('lots')->flatten();
	}

	public function getDepotsAttribute()
	{
		return $this->lots->pluck('depot')->flatten()->unique();
	}

	public function getCountriesAttribute()
	{
		$countries = collect([]);

		foreach (json_decode($this->countries_available) as $array_item) {
			$countries->push(\App\Country::find($array_item));
		}

		return $countries;
	}

	/**
	 * Relation for User Groups
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function user_groups()
	{
		return $this->belongsToMany('App\\UserGroup')
			->using('App\\DrugGroup')
			->withPivot('id');
	}


	/**
	 * Logo field relation
	 */
	public function get_logo()
	{
		return $this->belongsTo('App\\File', 'logo');
	}

	/**
	 * Relation for companies
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function company()
	{
		return $this->belongsTo('App\\Company');
	}

	/**
	 * Relation for documents
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function documents()
	{
		return $this->hasMany('App\\DrugDocument', 'drug_id');
	}
	public function activeDocuments()
	{
		return $this->hasMany('App\\DrugDocument', 'drug_id')->where('active','=', 1);
	}

	/**
	 * Relation for Resources
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function resources()
	{
		return $this->hasMany('App\\Resource');
	}

	/**
	 * Relation for Supplies
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function supplies()
	{
		return $this->hasMany('App\\DrugSupply');
	}

	public function visitSupplyLength($visit_number)
	{
		foreach($this->supplies->sortByDesc('supply_start') as $supply){
			if(($visit_number + 1) >= $supply->supply_start)
				return $supply;
		}
		return null;
	}

	/**
	 * Relation for components
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function components()
	{
		return $this->hasMany('App\\DrugComponent');
	}

	public function activeComponents()
	{
		return $this->components()->where('active', '=', 1);
	}

	/**
	 * Relation for Added By
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 */
	public function submitter()
	{
		return $this->belongsTo('App\\User', 'added_by');
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
	 * Add relationship for drugs to rids
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function rids()
	{
		return $this->hasMany('App\\Rid');
	}

	public function strippedShortDesc($except = null)
	{
		return strip_tags($this->short_desc, $except);
	}

	public function hasUser($id)
	{
		$users = $this->assignedUsers;
		if (!count($users))
			return false;
		$join = $users->firstWhere('user_id', $id);
		return (isset($join)) ? $join : false;
	}

	public function hasUserWhereInherited($id)
	{
		$users = $this->assignedUsers;
		if (!count($users))
			return false;
		$join = $users->firstWhere('user_id', $id);
		if (!isset($join))
			return false;
		else
			return $join->roleIsInherited();
	}

	public function hasUserWhereNotInherited($id)
	{
		$users = $this->assignedUsers;
		if (!count($users))
			return false;
		$join = $users->firstWhere('user_id', $id);
		if (!isset($join))
			return false;
		else
			return (!$join->roleIsInherited()) ? $join : false;
	}

	public static function allAllowed()
	{
		$user = User::where('id', \Auth::user()->id)->first();
		$allDrugs = Drug::all();
		$drugs = [];
		foreach ($allDrugs as $drug)
			if ($user->can('drug.index.view', $drug->id)) {
				array_push($drugs, $drug);
			}
		return collect($drugs);
	}

	public static function allAllowedStatus($user_id, $drug_status)
	{
		// dd($drug_status);
		$user = User::where('id', \Auth::user()->id)->first();
		if ($user->is_developer) {
			return Drug::where('drug.id', '!=', '')->where('drug.status', '=', $drug_status)->leftJoin('companies', 'companies.id', '=', 'drug.company_id')->select([
				'drug.id as id', 'drug.name as name', 'drug.company_id as company_id', 'companies.name as company_name', 'drug.status as status', 'drug.created_at as created_at'
			]);
		}
		if ($user->type == 'Early Access Care')
			return Drug::where('drug.id', '!=', '')->where('drug.status', '=', $drug_status)->leftJoin('companies', 'companies.id', '=', 'drug.company_id')->select([
				'drug.id as id', 'drug.name as name', 'drug.company_id as company_id', 'companies.name as company_name', 'drug.status as status', 'drug.created_at as created_at'
			]);
		elseif ($user->type == 'Pharmaceutical') {
			if (!$user->company_id)
				return 0;
			else
				return Drug::where('drug.company_id', $user->company_id)->where('drug.status', '=', $drug_status)->leftJoin('companies', 'companies.id', '=', 'drug.company_id')->select([
					'drug.id as id', 'drug.name as name', 'drug.company_id as company_id', 'companies.name as company_name', 'drug.status as status', 'drug.created_at as created_at'
				]);
		} else
			return 0;
	}

	public static function allAllowedD($user_id)
	{
		$user = User::where('id', \Auth::user()->id)->first();
		if ($user->is_developer) {
			return Drug::where('drug.id', '!=', '')->leftJoin('companies', 'companies.id', '=', 'drug.company_id')->select([
				'drug.id as id', 'drug.name as name', 'drug.company_id as company_id', 'companies.name as company_name', 'drug.status as status', 'drug.created_at as created_at'
			]);
		}
		if ($user->type == 'Early Access Care')
			return Drug::where('drug.id', '!=', '')->leftJoin('companies', 'companies.id', '=', 'drug.company_id')->select([
				'drug.id as id', 'drug.name as name', 'drug.company_id as company_id', 'companies.name as company_name', 'drug.status as status', 'drug.created_at as created_at'
			]);
		elseif ($user->type == 'Pharmaceutical') {
			if (!$user->company_id)
				return 0;
			else
				return Drug::where('drug.company_id', $user->company_id)->leftJoin('companies', 'companies.id', '=', 'drug.company_id')->select([
					'drug.id as id', 'drug.name as name', 'drug.company_id as company_id', 'companies.name as company_name', 'drug.status as status', 'drug.created_at as created_at'
				]);
		} else
			return 0;
	}
}
