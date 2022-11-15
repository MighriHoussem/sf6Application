<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Service\PersonService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function updatePerson(Request $request, PersonService $personService) : Response
    {
        try{
            $data = json_decode($request->getContent(), true);
            $id = $request->get('id');
            $personService->updatePerson($id,$data);
            return $this->json(['message' => 'Person Successfully Updated!'],200);
        }catch(Exception $ex){
            return $this->json([
                'error' => $ex->getMessage()
            ], 500);
        }

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
    #[Route('/findPersons', name: 'app_person_find', methods:['GET'])]
    public function findPersons (Request $request, PersonService $personService) : Response
    {
        $page = $request->query->get('page',0);
        $nbElements = $request->query->get('count',25);
        $orderBy = $request->query->get('orderColumn','age');
        $orderChoice = $request->query->get('orderChoice','ASC');
        $persons = $personService->findPersons($page, $nbElements, $orderBy, $orderChoice);
        return $this->json($persons, 200);
    }

    #[Route('/{id}', name: 'app_person_get', methods:['GET'])]
    public function getPerson(Request $request, Person $person): Response
    {
        return $this->json($person, 200);
    }

    #[Route('/form/edit/{id<\d+>?0}', name: 'person.add', methods:['GET', 'POST'])]
    public function addAction(Request $request,?Person $person = null, PersonService $personService, SluggerInterface $slugger): Response
    {
        if(!$person){
            $person = new Person();
        }

        $form = $this->createForm(PersonType::class, $person);
        //remove un used form inputs
        $form->remove('createdAt');
        $form->remove('updatedAt');
            
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('person_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $person->setImage($newFilename);
            }
        //$data = $form->getData();
            $personService->addPerson($person);
        $this->addFlash('success', "Person Added!");
            return $this->redirectToRoute('person.add');
        } else {
        return $this->render('person/add-person.html.twig', ['form' => $form->createView()]);
        }
    }

}
