<?php

namespace App\Controller;

use App\Entity\Projectweb;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function create(EntityManagerInterface $em,Request $request): Response
    {
      $projectweb = new Projectweb();
      $form =  $this->createForm(ProduitType::class, $projectweb);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid())
      {


          $em->persist($projectweb);
          $em->flush();

          $this->addFlash('notice','submitted successfully!');

          return  $this->redirectToRoute('app_main');
      }

      return $this->render('main/create.html.twig',[
          'form'=>  $form->createView()
      ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $projectweb = $projectwebRepository->find($id);

        $form = $this->createForm(ProduitType::class, $projectweb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projectweb);
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
            'controller_name' => 'MainController',
        ]);
    }


}
