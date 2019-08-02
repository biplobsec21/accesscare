<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Mailer
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Mailer extends Model
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
	protected $table = 'mailers';

	/**
	 * The prefix for the id
	 *
	 * @var string
	 */
	protected $prefix = "MAILER";

	public static $tokens = [
		'rid' => ['{rid_view}', '{rid_edit}', '{rid_post_approval}', '{rid.drug.name}', '{rid.number}', '{rid.created_at}'],
		'drug' => [],
		'user' => ['{user_view}', '{user_edit}', '{user_dashboard}', '{user.id}', '{user.full_name}', '{user.email}'],
	];

    public function getManageRouteAttribute()
    {
        return route('eac.portal.settings.mail.edit', $this->id);
    }
}
