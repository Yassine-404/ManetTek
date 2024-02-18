<?php

namespace App\Controller;

use App\Entity\Tournements;
use App\Form\TournementsType;
use App\Repository\TournementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tournements')]
class TournementsController extends AbstractController
{
    #[Route('/', name: 'app_tournements_index', methods: ['GET'])]
    public function index(TournementsRepository $tournementsRepository): Response
    {
        return $this->render('tournements/index.html.twig', [
            'tournements' => $tournementsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tournements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tournement = new Tournements();
        $form = $this->createForm(TournementsType::class, $tournement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tournement);
            $entityManager->flush();

            return $this->redirectToRoute('app_tournements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tournements/new.html.twig', [
            'tournement' => $tournement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tournements_show', methods: ['GET'])]
    public function show(Tournements $tournement): Response
    {
        return $this->render('tournements/show.html.twig', [
            'tournement' => $tournement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tournements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tournements $tournement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TournementsType::class, $tournement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tournements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tournements/edit.html.twig', [
            'tournement' => $tournement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tournements_delete', methods: ['POST'])]
    public function delete(Request $request, Tournements $tournement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tournement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tournement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tournements_index', [], Response::HTTP_SEE_OTHER);
    }
}
