<?php

namespace App\Controller;
use App\Entity\Sujet;
use App\Entity\User;
use App\Entity\Commentaire;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModerateurController extends AbstractController
{
    #[Route('/moderateur', name: 'app_moderateur')]
    public function index(): Response
    {
        $sujets = $this->getDoctrine()->getRepository(Sujet::class)->findAll();
        return $this->render('moderateur/index.html.twig', [
            'sujets' => $sujets,
        ]);
    }
}
