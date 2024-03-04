<?php

namespace App\Controller;


use App\Entity\Pmatch;
use App\Form\NewmatchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{

    #[Route('/match', name: 'app_match')]
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

    return $this->render('match/index.html.twig', [
        'formroom' => $form->createView(),

    ]);
}



}
