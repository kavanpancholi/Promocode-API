<?php

namespace App\Observers;

use App\Models\Event;

class EventObserver
{
    /**
     * @param Event $event
     */
    public function deleting(Event $event)
    {
        $event->promocodes()->detach();
    }
}
