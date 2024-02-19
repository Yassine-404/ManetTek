<?php

namespace App\Controller;

use App\Entity\Playeruser;

use App\Repository\PlayeruserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pmatch;
use App\Repository\PmatchRepository;


class MakeroomController extends AbstractController
{
    #[Route('/makeroom/{id}', name: 'app_makeroom')]




    public function updateroom(
        Request $request,
                $id,
        EntityManagerInterface $entityManager,
        PlayeruserRepository $playerRepository,
        PmatchRepository $pmatchRepository
    ) {
        $user = $this->getUser();

        if (!$user instanceof Playeruser) {
            throw new \RuntimeException('User must be an instance of Playeruser');
        }

        $pmatch = $pmatchRepository->find($id);

        if (!$pmatch instanceof Pmatch) {
            throw $this->createNotFoundException('Pmatch not found');
        }

        $user->setIdpmatch($pmatch);
        $entityManager->flush();

        // Retrieve all active users whose getIdpmatch() is equal to $id
        $activeUsers = $playerRepository->findBy(['idpmatch' => $pmatch]);

        // Redirect to a success page or any other action
        return $this->render('makeroom/index.html.twig', [
            'pmatch' => $pmatch,
            'activeUsers' => $activeUsers,
        ]);
    }
}