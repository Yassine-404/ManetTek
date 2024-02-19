<?php

namespace App\Controller;

use App\Entity\Pmatch;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainmatchController extends AbstractController
{
    #[Route('/mainmatches', name: 'matches')]
    public function listPlayer(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Pmatch::class);
        $list = $repository->findAll();
        dump($list);


    return $this->render('mainmatch/index.html.twig', [
        'test' => $list
    ]);
}
}
