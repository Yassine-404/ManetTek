<?php

namespace App\Controller;

use App\Entity\Jeux;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\JeuxType;

class JeuxController extends AbstractController
{
    #[Route('/jeux', name: 'app_jeux')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeux = $jeuxRepository->findAll();

        return $this->render('jeux/index.html.twig', [
            'jeux' => $jeux,
            'controller_name' => 'JeuxController',
        ]);
    }

    #[Route('/jeux/create', name: 'jeux_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $jeu = new Jeux();
        $form = $this->createForm(JeuxType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jeu);
            $entityManager->flush();

            $this->addFlash('notice', 'Jeux created successfully!');

            return $this->redirectToRoute('app_jeux');
        }

        return $this->render('jeux/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/jeux/update/{id}', name: 'jeux_update')]
    public function update(EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeu = $jeuxRepository->find($id);

        if (!$jeu) {
            throw $this->createNotFoundException('Jeux not found');
        }

        $form = $this->createForm(\JeuxType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('notice', 'Jeux updated successfully!');

            return $this->redirectToRoute('app_jeux');
        }

        return $this->render('jeux/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/jeux/delete/{id}', name: 'jeux_delete')]
    public function delete(EntityManagerInterface $entityManager, $id): Response
    {
        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeu = $jeuxRepository->find($id);

        if (!$jeu) {
            throw $this->createNotFoundException('Jeux not found');
        }

        $entityManager->remove($jeu);
        $entityManager->flush();

        $this->addFlash('notice', 'Jeux deleted successfully!');

        return $this->redirectToRoute('app_jeux');
    }

    #[Route('/jeux/store-jeux', name: 'store-jeux')]
    public function store(EntityManagerInterface $entityManager): Response
    {
        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeux = $jeuxRepository->findAll();

        return $this->render('jeux/store-jeux.html.twig', [
            'list' => $jeux,
            'controller_name' => 'MainController',
        ]);
    }
}
