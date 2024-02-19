<?php

namespace App\Controller;

use App\Entity\Playeruser;
use App\Form\RegistrationFormType;
use App\Repository\PlayeruserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(PlayeruserRepository $player): Response
    {
        $player=$player->findAll();
        return $this->render(view:'admin/index.html.twig', parameters: [
            'list' => $player
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, $id): Response
    {
        $player = $entityManager->getRepository(Playeruser::class);
        $player = $player->find($id);

        $entityManager->remove($player);
        $entityManager->flush();



        return $this->redirectToRoute('app_admin');
    }


    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request,$id, EntityManagerInterface $entityManager, PlayeruserRepository $playerRepository)
    {
        $player = $playerRepository->find($id);
        $form = $this->createForm(RegistrationFormType::class, $player);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            dump($player);

            // Redirect to a success page or any other action
            //return $this->redirectToRoute('display');
            return $this->redirectToRoute("app_admin");
        }

        return $this->render('admin/update.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
