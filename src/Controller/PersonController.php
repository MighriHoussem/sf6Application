<?php

namespace App\Controller;

use App\Entity\Person;
use App\Service\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/person')]
class PersonController extends AbstractController
{
    #[Route('/', name: 'app_person')]
    public function index(): Response
    {
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }
    #[Route('/create', name: 'app_person_create', methods:['POST', 'PUT'])]
    public function create(Request $request, PersonService $personService): Response
    {
        $data = json_decode($request->getContent(),true);
        $person = new Person();
        $person->setFirstname($data['firstName']);
        $person->setName($data['name']);
        $person->setAge($data['age']);
        $person->setNo($data['no']);
        $person->setJob($data['job']);
        $personService->addPerson($person);
        $this->addFlash('success', 'Person Successfully created');
        /**return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);*/
        return $this->json(['message' => 'Person Successfully Created!'], 200);
    }
    #[Route('/update/{id<\d+>}', name: "app_person_update", methods:['PUT'])]
    public function updatePerson(Request $request, Person $person, PersonService $personService) : Response
    {
        $data = json_decode($request->getContent(), true);
        //$id = $request->get('id');
        $personService->updatePerson($person,$data);
        return $this->json(['message' => 'Person Successfully Updated!'],200);
    }

    #[Route('/all', name: 'app_person_list', methods:['GET'])]
    public function listPersons (Request $request, PersonService $personService) : Response
    {
        $persons = $personService->getAllPersons();
        return $this->json($persons, 200);
    }

    #[Route('/remove/{id<\d+>}', name: 'app_person_remove', methods:['DELETE'])]
    public function removePerson (Request $request, PersonService $personService): Response
    {
        $idPerson = $request->get('id');
        $personService->deletePerson($idPerson);
        return $this->json(['message' => "Person with ID: $idPerson Deleted!"], 200);
    }

}
