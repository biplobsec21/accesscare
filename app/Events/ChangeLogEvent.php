<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class ChangeLogEvent
{
	use SerializesModels;

	public $data;

	/**
	 * Create a new event instance.
	 *
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}
}
