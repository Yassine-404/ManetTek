<?php

namespace App\Controller;

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

    #[Route('/checkout/{totalPrix}', name: 'payment_checkout')]
    public function checkout($totalPrix): Response
    {
        //dump($totalPrix);
        \Stripe\Stripe::setApiKey('sk_test_51Oq4FVJR9ECOGQZlj3dkB98HjAySfzsEQqKOCuFiQ1pVfsM5rqYG9zXNfnFKCXAaqa6pIWAk1b0Ya2vtvWZBxVuQ00n6x77qED');
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => 'Cart Purshace',
                        ],
                        'unit_amount'  => $totalPrix * 100,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL) . '?totalPrix=' . $totalPrix,
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }


    #[Route('/success-url', name: 'success_url')]
    public function success(Request $request): Response
    {
        $totalPrix = $request->query->get('totalPrix');
        return $this->render('payment/success.html.twig', [
            'controller_name' => 'PaymentController',
            'totalPrix' => $totalPrix,
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
