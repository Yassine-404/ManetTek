<?php

namespace App\Controller;

use App\Entity\Playeruser;
use App\Entity\Pmatch;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainmatchController extends AbstractController
{
    #[Route('/mainmatches', name: 'matches', methods: ['GET'])]
    public function listPlayer(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Pmatch::class);

        $postsPerPage = 9;
        $currentPage = $request->query->getInt('page', 1);
        $totalPosts = $repository->count([]);
        $totalPages = ceil($totalPosts / $postsPerPage);
        $offset = ($currentPage - 1) * $postsPerPage;

        $matches = $repository->findBy([], null, $postsPerPage, $offset);

        return $this->render('mainmatch/index.html.twig', [
            'matches' => $matches,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, $id): Response
    {
        $pmatch = $entityManager->getRepository(Pmatch::class);
        $pmatch = $pmatch->find($id);

        $entityManager->remove($pmatch);
        $entityManager->flush();



        return $this->redirectToRoute('matches');
    }
}