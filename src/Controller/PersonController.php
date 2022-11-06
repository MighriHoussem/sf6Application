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
        $person->setFirstname('Ali');
        $person->setName('SALAH');
        $person->setAge(28);
        $person->setNo('698');
        $personService->addPerson($person);
        $this->addFlash('success', 'Person Successfully created');
        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
        ]);
    }

}
