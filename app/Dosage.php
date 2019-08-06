<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Dosage
 * @package EAC
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Dosage extends Model {



	/**
	 * Indicates if the model should automatically increment the id
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * The event map for the model.
	 * @var array
	 */
	protected $dispatchesEvents = ['saved' => \App\Events\ChangeLogEvent::class,];

	/**
	 * Indicates if the model should be timestamped.
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * The table associated with the model.
	 * @var string
	 */
	protected $table = 'dosages';

	/**
	 * The prefix for the id
	 * @var string
	 */
	protected $prefix = "DOSAGE";

	public function getEditRouteAttribute()
    {
        return route('eac.portal.settings.manage.drug.dosage.edit', $this->id);
    }

    public function lots() {
		return $this->HasMany('App\\DrugLot');
	}

	public function form() {
		return $this->hasOne('App\\DosageForm', 'id', 'form_id');
	}

	public function unit() {
		return $this->hasOne('App\\DosageUnit', 'id', 'unit_id');
	}

	public function component() {
		return $this->belongsTo('App\\DrugComponent');
	}

	public function strength() {
		return $this->hasOne('App\\DosageStrength', 'id', 'strength_id');
	}

    public function getDoseAttribute() {
        return $this->amount . ' ' . $this->unit->name;
    }

    public function getDisplayShortAttribute()
    {
        $str = '<div>';
        $str .= $this->form->name . ' ';
        $str .= $this->amount . ' ';
        $str .= $this->unit->name . ' ';
        $str .= '</div>';
        return $str;
    }
}
