<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/Login', name: 'app_inscription')]
    public function index(): Response
    {
        return $this->render('subscribe/baseAdmin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/personne', name: 'subs_User')]
    public function indexIsncri(): Response
    {
        return $this->render('Login/baseAdmin.html.twig'
        );
    }
}
