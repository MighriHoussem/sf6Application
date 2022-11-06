<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(Request $request): Response
    {
        $filter = $request->query->get('filter');
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
            'filterName' => $filter
        ]);
    }

    #[Route('/infos', name: 'app_infos')]
    public function infos(Request $request, SessionInterface $session) : Response
    {
        return new Response("Hello its Symfony 6", 200);
    }

    #[
        Route('/sayHello/{name?houssem}/{country?Tunisia}/{postal?8001}', 
        name: 'sayHello',
        requirements: [
            'postal' => '\d+'
        ]
        )]
    public function sayHello(Request $request) : Response
    {
        $name = $request->get('name',null);
        $country = $request->get('country', null);
        $postalCode = $request->get('postal');
        $int = rand(0,10);
        if($int % 2 === 0 ){
            return $this->redirectToRoute('app_first');
        }
        return $this->render(
                'first/hello.html.twig',
                [
                    'message' => 'Say Hello Page shown!',
                    'name' => $name,
                    'country' => $country,
                    'postalCode' => $postalCode
                ]
            );
    }
}
