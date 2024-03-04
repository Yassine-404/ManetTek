<?php

namespace App\Controller;
use App\Form\CommentaireType;
use App\Form\SujetType;

use App\Entity\Sujet;
use App\Entity\User;
use App\Entity\Commentaire;
use App\Service\EmailService;
use App\Repository\SujetRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    #[Route('/moderateur/modifier/{id}', name: 'app_moderateur_modifier')]
    public function modifier(Request $request, Sujet $sujet): Response
    {
        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('app_moderateur');
        }

        return $this->render('moderateur/modifier.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/blocage/{id}', name: 'app_moderateur_blocage', methods: ['POST'])]
    public function blocage(Sujet $sujet): RedirectResponse
    {
        // Inversez l'état actif du sujet
        $sujet->setActif(!$sujet->isActif());

        // Enregistrez les modifications dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        // Redirigez l'utilisateur vers la page de modération
        return $this->redirectToRoute('app_moderateur');
    }
}
