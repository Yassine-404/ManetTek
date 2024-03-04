<?php

namespace App\Controller;

use App\Entity\Rating;
use App\Form\RatingType;
use App\Repository\RatingRepository;
use App\Repository\TournementsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rating')]
class RatingController extends AbstractController
{
    #[Route('/new/{iduser}/{idtournement}', name: 'app_rating_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, TournementsRepository $tournementsRepository, RatingRepository $ratingRepository, EntityManagerInterface $entityManager, $iduser, $idtournement): Response
    {
        // Recherche de l'utilisateur et du tournoi à partir des identifiants
        $user = $userRepository->find($iduser);
        $tournement = $tournementsRepository->find($idtournement);

        // Recherche d'un rating existant pour l'utilisateur et le tournoi donnés
        $existingRating = $ratingRepository->findOneBy([
            'userId' => $iduser,
            'tournementsId' => $idtournement,
        ]);

        if (!$user || !$tournement) {
            throw $this->createNotFoundException('User or Tournament not found');
        }

        // Création d'une nouvelle instance de Rating
        $rating = new Rating();
        $rating->setUserId($iduser);
        $rating->setTournementsId($idtournement);
        $form = $this->createForm(RatingType::class, $rating);
        $form->handleRequest($request);

        if ($existingRating) {
            // Un rating existe déjà pour cet utilisateur et ce tournoi
            // Gérer ce cas selon vos besoins, par exemple, afficher un message d'erreur à l'utilisateur
            // Vous pouvez également rediriger l'utilisateur ou afficher un message
        } else {
            // Aucun rating existant pour cet utilisateur et ce tournoi, créer un nouveau rating
            if ($form->isSubmitted() && $form->isValid()) {
                // Enregistrer le nouveau rating
                $entityManager->persist($rating);
                $entityManager->flush();

                // Rediriger l'utilisateur vers la page du tournoi
                return $this->redirectToRoute('app_tournement_show', ['id' => $idtournement]);
            }
        }

        // Afficher le formulaire de création de notation
        return $this->renderForm('rating/new.html.twig', [
            'rating' => $rating,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rating_delete', methods: ['POST'])]
    public function delete(Request $request, Rating $rating, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rating->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rating);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rating_index', [], Response::HTTP_SEE_OTHER);
    }
}
