<?php

namespace App\EventSubscriber;

use App\Event\AddPersonEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

class PersonEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            AddPersonEvent::ADD_PERSON_EVENT => ['onAddPersonEvent', 200]
            ];
    }

    public function onAddPersonEvent(AddPersonEvent $event)
    {
        dd('eventSubscriber => '. print_r($event->getAddedPerson()->getFirstname(), true));
    }
}
