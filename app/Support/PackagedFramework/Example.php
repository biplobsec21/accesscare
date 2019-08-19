<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Example
 * @package App
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Example extends BaseModel
{

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'examples';

	protected $attributes = [
	    'id',
        'user_id',
        'created_at',
        'updated_at',
    ];
}
