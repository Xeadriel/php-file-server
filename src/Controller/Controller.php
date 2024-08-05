<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {   
        return $this->render('/index.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }

    #[Route('/create', name: 'createpage')]
    public function createpage(): Response
    {   
        return $this->render('/createpage/CreatePage.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }

    #[Route('/aboutus', name: 'aboutus')]
    public function aboutus(): Response
    {   
        return $this->render('/aboutUs.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }

    
}
