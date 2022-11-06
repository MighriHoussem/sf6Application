<?php
namespace App\Service;

use App\Entity\Person;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PersonService{

    private $entityManager;

    public function __construct(EntityManagerInterface $Manager)
    {
        $this->entityManager = $Manager;
    }
    public function addPerson (Person $person) : bool 
    {
        try{
            $this->entityManager->persist($person);
            $this->entityManager->flush();
            return true;
            //$this->entityManager->getRepository(Person::class)->findAll();
        }catch(Exception $e){
            return false;
        }
    }
}