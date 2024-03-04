<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    #[Route('/checkout/{totalPrix}/{userId}', name: 'payment_checkout')]
    public function checkout(UtilisateurRepository $utilisateurRepository, $totalPrix, $userId, EntityManagerInterface $entityManager): Response
    {
        \Stripe\Stripe::setApiKey('sk_test_51Oq4FVJR9ECOGQZlj3dkB98HjAySfzsEQqKOCuFiQ1pVfsM5rqYG9zXNfnFKCXAaqa6pIWAk1b0Ya2vtvWZBxVuQ00n6x77qED');

        $user = $entityManager->getRepository(User::class)->findBy(['id' => $userId]);
        dump($user);
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => $user[0]->getNom() . '\'s Cart Purchase',
                        ],
                        'unit_amount'  => $totalPrix * 100,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL) . '?totalPrix=' . $totalPrix . '&userEmail=' . $user[0]->getEmail() . '&userNom=' . $user[0]->getNom() . '&userPrenom=' . $user[0]->getPrenom() . '&userAdress=' . $user[0]->getAdress() . '&userVille=' . $user[0]->getVille() . '&userZipCode=' . $user[0]->getZipcode(),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }


    #[Route('/success-url', name: 'success_url')]
    public function success(Request $request): Response
    {
        $totalPrix = $request->query->get('totalPrix');
        $userEmail = $request->query->get('userEmail');
        $userNom = $request->query->get('userNom');
        $userPrenom = $request->query->get('userPrenom');
        $userAdress = $request->query->get('userAdress');
        $userVille = $request->query->get('userVille');
        $userZipCode = $request->query->get('userZipCode');
        return $this->render('payment/success.html.twig', [
            'controller_name' => 'PaymentController',
            'totalPrix' => $totalPrix,
            'userEmail' => $userEmail,
            'userNom' => $userNom,
            'userPrenom' => $userPrenom,
            'userAdress' => $userAdress,
            'userVille' => $userVille,
            'userZipCode' => $userZipCode,
        ]);
    }
    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

}
