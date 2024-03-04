<?php

namespace App\Controller;

use App\Entity\Pmatch;
use App\Form\NewmatchType;
use App\Entity\Playeruser;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreeroomController extends AbstractController
{
    #[Route('/creeroom', name: 'app_creeroom')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {

        $match = new Pmatch();
        $form = $this->createForm(NewmatchType::class, $match);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($match);
            $entityManager->flush();


            return $this->redirect($this->generateUrl('app_makeroom',['id' => $match->getId()]));
        }

        return $this->render('creeroom/index.html.twig', [
            'fmatch' => $form->createView(),
            'match' => $match,

        ]);
    }
}
