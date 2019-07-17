<?php

namespace App\Listeners;

use App\Log;
use App\Traits\Logger;
use App\Events\ChangeLogEvent;

class ChangeLog
{
	use Logger;

	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  ChangeLogEvent $event
	 * @return mixed
	 */
	public function handle(ChangeLogEvent $event)
	{
		$create = "";
		$update = "";
		$TypeArray=array();

		if (array_key_exists('last_seen', $event->data->getChanges())) {
			return true;
		}
		if ($event->data->wasRecentlyCreated) {
			
			if($event->data->getPrefix()){

				$TypeArray['table_name'] = $event->data->getTableName();
				$TypeArray['message'] = ucwords(strtolower($event->data->getPrefix()))." Creation";
				$TypeArray['activity'] = "Create";
				$create=json_encode($TypeArray);

			}

			$this->storeLog($event->data->id, $event->data,$create);

		} else {
			if ($event->data->getChanges()) {
				if($event->data->getPrefix()){
					$TypeArray['table_name'] = $event->data->getTableName();
					$TypeArray['message'] = ucwords(strtolower($event->data->getPrefix()))." Update";
					$TypeArray['activity'] = "Edit";
					$update=json_encode($TypeArray);		
				}

				$this->storeLog($event->data->id, $event->data->getChanges(),$update);
			}
		}
	}
}