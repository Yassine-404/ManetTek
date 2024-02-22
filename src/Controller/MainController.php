<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Projectweb;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $data = $projectwebRepository->findAll();

        return $this->render('main/index.html.twig', [
            'list' => $data,
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/admin', name: 'display_admin')]
    public function indexAdmin(EntityManagerInterface $entityManager): Response
    {
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $data = $projectwebRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'list' => $data,
            'controller_name' => 'MainController',
        ]);
    }

     #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em,Request $request , #[Autowire('%photo_dir%')] string $photoDir): Response
    {
      $projectweb = new Projectweb();
      $form =  $this->createForm(ProduitType::class, $projectweb);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid())
      {


          $em->persist($projectweb);
          if($photo = $form['photo']->getData()){
              $fileName = uniqid().'.'.$photo->guessExtension();
              $photo->move($photoDir,$fileName);
              $projectweb->setImageP($fileName);
          }
          $em->flush();

          $this->addFlash('notice','submitted successfully!');

          return  $this->redirectToRoute('app_main');
      }

      return $this->render('main/create.html.twig',[
          'form'=>  $form->createView()
      ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(EntityManagerInterface $entityManager, Request $request, $id , #[Autowire('%photo_dir%')] string $photoDir): Response
    {
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $projectweb = $projectwebRepository->find($id);

        $form = $this->createForm(ProduitType::class, $projectweb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projectweb);
            if($photo = $form['photo']->getData()){
                $fileName = uniqid().'.'.$photo->guessExtension();
                $photo->move($photoDir,$fileName);
                $projectweb->setImageP($fileName);
            }

            $entityManager->flush();

            $this->addFlash('notice', 'Update successful!');

            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
        #[Route('/delete/{id}', name: 'delete')]
        public function delete(EntityManagerInterface $entityManager, $id): Response
        {
            $projectwebRepository = $entityManager->getRepository(Projectweb::class);
            $data = $projectwebRepository->find($id);

            $entityManager->remove($data);
            $entityManager->flush();

            $this->addFlash('notice', 'Delete successful!');

            return $this->redirectToRoute('app_main');
        }

    #[Route('/store', name: 'store')]
    public function store(EntityManagerInterface $entityManager): Response
    {
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $data = $projectwebRepository->findAll();

        return $this->render('main/store.html.twig', [
            'list' => $data,
            'noResults' => empty($data),
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/search', name: 'search')]
    public function search(Request $request, EntityManagerInterface $entityManager): Response
    {
        $keyword = $request->query->get('keyword');
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);

        // Fetch peripherals based on the search keyword
        if (!empty($keyword)) {
            $data = $projectwebRepository->findByKeyword($keyword);
        } else {
            $data = $projectwebRepository->findAll(); // Fetch all peripherals
        }

        // Check if any peripherals were found
        $noResults = empty($data);


        return $this->render('main/store.html.twig', [
            'list' => $data,
            'controller_name' => 'MainController',
            'noResults' => empty($data), // Pass the noResults variable to the template
            'keyword' => $keyword ?? '', // Pass the keyword variable to the template
        ]);
    }
    #[Route('/pc-peripherals', name: 'pc_peripherals')]
    public function pcPeripherals(EntityManagerInterface $entityManager, Request $request): Response
    {
        $categorieName = $request->query->get('categorie');
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['Type' => $categorieName]);

        if (!$categorie) {
            throw $this->createNotFoundException('Category PC not found.');
        }

        // Find peripherals with category 'PC'
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $data = $projectwebRepository->findBycategorie($categorie);

        return $this->render('main/store.html.twig', [
            'list' => $data,
            'noResults' => empty($data),
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/ps-peripherals', name: 'ps_peripherals')]
    public function psPeripherals(EntityManagerInterface $entityManager, Request $request): Response
    {
        $categorieName = 'PS'; // Set the category name
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['Type' => $categorieName]);

        if (!$categorie) {
            throw $this->createNotFoundException('Category PS not found.');
        }

        // Find peripherals with category 'PS'
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $data = $projectwebRepository->findBycategorie($categorie);

        return $this->render('main/store.html.twig', [
            'list' => $data,
            'noResults' => empty($data),
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/xbox-peripherals', name: 'xbox_peripherals')]
    public function xboxPeripherals(EntityManagerInterface $entityManager, Request $request): Response
    {
        $categorieName = 'Xbox'; // Set the category name
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['Type' => $categorieName]);

        if (!$categorie) {
            throw $this->createNotFoundException('Category Xbox not found.');
        }

        // Find peripherals with category 'Xbox'
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $data = $projectwebRepository->findBycategorie($categorie);

        return $this->render('main/store.html.twig', [
            'list' => $data,
            'noResults' => empty($data),
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/all-peripherals', name: 'all_peripherals')]
    public function allPeripherals(EntityManagerInterface $entityManager): Response
    {
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $data = $projectwebRepository->findAll();

        return $this->render('main/store.html.twig', [
            'list' => $data,
            'noResults' => empty($data),
            'controller_name' => 'MainController',
        ]);
    }










}
