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

    public function updatePerson(int $id, ?array $data = []) : bool
    {
        try{
            $personRepository = $this->entityManager->getRepository(Person::class);
            $findPerson = $personRepository->find($id);
            $findPerson->setFirstname($data['firstname']);
            $findPerson->setAge($data['age']);
            $findPerson->setName($data['name']);
            $findPerson->setJob($data['job']);
            $findPerson->setNo($data['no']);
            $this->entityManager->flush();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public function getAllPersons () : array|bool
    {
        try{
            $persons = $this->entityManager->getRepository(Person::class)->findAll();
            return $persons;
        }catch(Exception $ex){
            return [];
        }

    }

    public function deletePerson (int $idPerson): bool
    {
        try{
            $person = $this->entityManager->getRepository(Person::class)->find($idPerson);
            if($person){
                $this->entityManager->remove($person);
                $this->entityManager->flush();
            }
            return true;
        }catch(Exception $ex){
            return false;
        }
    }

    public function findPersons(int $page, int $count, string $orderColumn, string $orderChoice) : array|bool 
    {
        try{
            $persons = $this->entityManager->getRepository(Person::class)->findPersonsByPage($page, $count, $orderColumn, $orderChoice);
            return $persons;
        }catch(Exception $e){
            var_dump($e->getMessage());
            return [];
        }
    }
}