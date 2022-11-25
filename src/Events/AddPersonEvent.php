<?php

namespace App\Event;

use App\Entity\Person;
use Symfony\Contracts\EventDispatcher\Event;

class AddPersonEvent extends Event
{
    public const ADD_PERSON_EVENT = "person.add";
    public function __construct(private Person $person)
    {
    }
    public function getAddedPerson(): Person
    {
        return $this->person;
    }
}
