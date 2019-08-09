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
     * @param ChangeLogEvent $event
     * @return void
     */
    public function handle(ChangeLogEvent $event)
    {
        if ($event->data->wasRecentlyCreated) {
            $desc = ['action' => "create", 'record' => $event->data];
            $this->storeLog($event->data->id, $desc, $event->data->getTable());
        } else if ($event->data->getChanges()) {
            $desc = ['action' => "update", 'changes' => $event->data->getChanges(), 'record' => $event->data->getOriginal()];
            $this->storeLog($event->data->id, $desc, $event->data->getTable());
        }
    }
}
