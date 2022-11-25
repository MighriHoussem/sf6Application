<?php

namespace App\EventListener;

use Symfony\Contracts\EventDispatcher\Event;

class PersonListener
{
    public function onAddPerson(Event $event)
    {
        dd('Person onAdd Listener => '. $event->getAddedPerson()->getName());
    }
}
