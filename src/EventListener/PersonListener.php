<?php

namespace App\EventListener;

use App\Event\AddPersonEvent;
use Symfony\Contracts\EventDispatcher\Event;

class PersonListener
{
    public function onAddPerson(AddPersonEvent $event)
    {
        //just say we have the event data && show it on UI
        dd('Person onAdd Listener => '. $event->getAddedPerson()->getName());
    }
}
