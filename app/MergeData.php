<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
/**
 * Class ShippingCourier
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class MergeData extends Model
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
    protected $table = 'merge_data';

    /**
     * The prefix for the id
     *
     * @var string
     */
    protected $prefix = "MERGEDATA";

}
