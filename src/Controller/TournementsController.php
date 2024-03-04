<?php

namespace App\Controller;

use App\Entity\Tournements;
use App\Form\TournementsType;
use App\Repository\TournementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tournements')]
class TournementsController extends AbstractController
{
    #[Route('/', name: 'app_tournements_index', methods: ['GET'])]
    public function index(Request $request, TournementsRepository $tournementsRepository): Response
    {
        $searchTerm = $request->query->get('search');
        
        if ($searchTerm) {
            $tournaments = $tournementsRepository->findByNom($searchTerm);
        } else {
            $tournaments = $tournementsRepository->findAll();
        }

        return $this->render('tournements/index.html.twig', [
            'tournaments' => $tournaments,
        ]);
    }

    #[Route('/new', name: 'app_tournements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tournement = new Tournements();
        $form = $this->createForm(TournementsType::class, $tournement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleFormSubmission($form, $tournement, $entityManager);

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
            $this->handleFormSubmission($form, $tournement, $entityManager);

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

    private function handleFormSubmission($form, $tournement, $entityManager): void
    {
        // Gérer l'ajout de l'image du tournoi
        $tournementImage = $form->get('tournementImage')->getData();
        $this->uploadTournementImage($tournementImage, $tournement);

        // Gérer l'ajout de la vidéo du tournoi
        $tournementVideo = $form->get('tournementVideo')->getData();
        $this->uploadTournementVideo($tournementVideo, $tournement);

        $entityManager->persist($tournement);
        $entityManager->flush();
    }

    private function uploadTournementImage($tournementImage, $tournement): void
    {
        if ($tournementImage) {
            $fileName = uniqid().'.'.$tournementImage->guessExtension();

            // Move the file to the directory where images are stored
            try {
                $tournementImage->move(
                    $this->getParameter('tournement_images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // Handle file upload exception
            }

            // Update the 'tournementImage' property of the Tournement entity
            $tournement->setTournementImage($fileName);
        }
    }

    private function uploadTournementVideo($tournementVideo, $tournement): void
    {
        if ($tournementVideo) {
            $fileName = uniqid().'.'.$tournementVideo->guessExtension();

            // Move the file to the directory where videos are stored
            try {
                $tournementVideo->move(
                    $this->getParameter('tournement_videos_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // Handle file upload exception
            }

            // Update the 'tournementVideo' property of the Tournement entity
            $tournement->setTournementVideo($fileName);
        }
    }
}
