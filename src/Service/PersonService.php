<?php
namespace App\Service;

use App\Entity\Person;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class PersonService{

    private $entityManager;

    public function __construct(ManagerRegistry $Manager)
    {
        $this->entityManager = $Manager->getManager();
    }
    public function addPerson (Person $person) : bool 
    {
        try{
            $this->entityManager->persist($person);
            $this->entityManager->flush();
            return true;
            //$this->entityManager->getRepository(Person::class)->findAll();
        }catch(Exception $e){
            throw $e;
        }
    }

    public function updatePerson(int $id, ?array $data = []) : bool|Exception
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
            throw $e;
        }
    }

    public function getAllPersons () : array|Exception
    {
        try{
            $persons = $this->entityManager->getRepository(Person::class)->findAll();
            return $persons;
        }catch(Exception $ex){
            throw $ex;
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
            throw $ex;
        }
    }

    public function findPersons(int $page, int $count, string $orderColumn, string $orderChoice) : array|bool|Exception
    {
        try{
            $persons = $this->entityManager->getRepository(Person::class)->findPersonsByPage($page, $count, $orderColumn, $orderChoice);
            return $persons;
        }catch(Exception $e){
            throw $e;
        }
    }
}