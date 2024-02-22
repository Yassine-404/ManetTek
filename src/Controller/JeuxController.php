<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Jeux;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
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
    public function create(EntityManagerInterface $entityManager, Request $request, #[Autowire('%photo_dir%')] string $photoDir): Response
    {
        $jeu = new Jeux();
        $form = $this->createForm(JeuxType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jeu);
            if($photo = $form['photo']->getData()){
            $fileName = uniqid().'.'.$photo->guessExtension();
            $photo->move($photoDir,$fileName);
                $jeu->setImagej($fileName);
            }

            $entityManager->flush();

            $this->addFlash('notice', 'Jeux created successfully!');

            return $this->redirectToRoute('app_jeux');
        }

        return $this->render('jeux/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/jeux/update/{id}', name: 'jeux_update')]
    public function update(EntityManagerInterface $entityManager, Request $request, $id , #[Autowire('%photo_dir%')] string $photoDir): Response
    {
        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeu = $jeuxRepository->find($id);

        if (!$jeu) {
            throw $this->createNotFoundException('Jeux not found');
        }

        $form = $this->createForm(JeuxType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($photo = $form['photo']->getData()){
                $fileName = uniqid().'.'.$photo->guessExtension();
                $photo->move($photoDir,$fileName);
                $jeu->setImagej($fileName);
            }
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
            'noResults' => empty($data),
            'controller_name' => 'MainController',

        ]);
    }
    #[Route('/Search', name: 'search_jeux')]
    public function searchJeux(Request $request, EntityManagerInterface $entityManager): Response
    {
        $keyword = $request->query->get('keyword');
        $jeuxRepository = $entityManager->getRepository(Jeux::class);

        // Fetch Jeux based on the search keyword
        if (!empty($keyword)) {
            $jeux = $jeuxRepository->findByKeyword($keyword);
        } else {
            $jeux = $jeuxRepository->findAll(); // Fetch all Jeux
        }

        // Check if any Jeux were found
        $noResults = empty($jeux);

        return $this->render('jeux/store-jeux.html.twig', [
            'list' => $jeux,
            'controller_name' => 'JeuxController',
            'noResults' => empty($data), // Pass the noResults variable to the template
            'keyword' => $keyword ?? '', // Pass the keyword variable to the template
        ]);
    }
    #[Route('/jeux/pc', name: 'jeux_pc')]
    public function pcGames(EntityManagerInterface $entityManager): Response
    {
        $categorieName = 'PC';
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['Type' => $categorieName]);

        if (!$categorie) {
            throw $this->createNotFoundException('Category PC not found.');
        }

        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeux = $jeuxRepository->findBy(['categorie' => $categorie]);

        return $this->render('jeux/store-jeux.html.twig', [
            'list' => $jeux,
            'noResults' => empty($data),
            'controller_name' => 'JeuxController',
        ]);
    }

    #[Route('/jeux/ps4', name: 'jeux_ps4')]
    public function ps4Games(EntityManagerInterface $entityManager): Response
    {
        $categorieName = 'PS';
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['Type' => $categorieName]);

        if (!$categorie) {
            throw $this->createNotFoundException('Category PS4 not found.');
        }

        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeux = $jeuxRepository->findBy(['categorie' => $categorie]);

        return $this->render('jeux/store-jeux.html.twig', [
            'list' => $jeux,
            'noResults' => empty($data),
            'controller_name' => 'JeuxController',
        ]);
    }

    #[Route('/jeux/xbox', name: 'jeux_xbox')]
    public function xboxGames(EntityManagerInterface $entityManager): Response
    {
        $categorieName = 'Xbox';
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['Type' => $categorieName]);

        if (!$categorie) {
            throw $this->createNotFoundException('Category Xbox not found.');
        }

        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeux = $jeuxRepository->findBy(['categorie' => $categorie]);

        return $this->render('jeux/store-jeux.html.twig', [
            'list' => $jeux,
            'noResults' => empty($data),
            'controller_name' => 'JeuxController',
        ]);
    }
    #[Route('/all-jeux', name: 'all_jeux')]
    public function allJeux(EntityManagerInterface $entityManager): Response
    {
        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeux = $jeuxRepository->findAll();

        return $this->render('jeux/store-jeux.html.twig', [
            'list' => $jeux,
            'noResults' => empty($data),
            'controller_name' => 'JeuxController',
        ]);
    }
    #[Route('/search-prix', name: 'search_prix')]
    public function searchPrix(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the price range from the request
        $minPrice = $request->query->get('minPrice', 0);
        $maxPrice = $request->query->get('maxPrice', 0);

        // Query the database for jeux within the price range
        $jeuxRepository = $entityManager->getRepository(Jeux::class);
        $jeux = $jeuxRepository->findByPriceRange($minPrice, $maxPrice);

        return $this->render('jeux/store-jeux.html.twig', [
            'list' => $jeux,
            'noResults' => empty($jeux), // Check if any jeux were found
            'controller_name' => 'JeuxController',
        ]);
    }





}
