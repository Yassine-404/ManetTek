<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;

class StripeController extends AbstractController
{
    #[Route('/stripe/{prixtotal}', name: 'app_stripe', methods: ['GET', 'POST'])]
    public function index(Request $request, $prixtotal): Response
    {
        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["pk_test_51Opf0YGuFNfsyENx0htq4BSfMh8Um5UpSabOOrDAvSO6Wv8h91e62BPaLXbFMzxJxoNg6PD6EsMBXaUqcO69Ak7O009PYjz8IA"],
            'prixtotal' => $prixtotal,
        ]);
    }

    #[Route('/stripepay/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request): Response
    {
        try {
            Stripe::setApiKey($_ENV["sk_test_51Opf0YGuFNfsyENxTXppJWaonOtc41dBUytYqX3iTC870eMs7UAM9hSmHl8ghqmiSkoGdmiJUIYEDiYHkJ2q3GOv00tecGU8l1"]);

            $token = $request->request->get('stripeToken');
            $amount = $request->request->get('amount'); // Récupérer le montant depuis le formulaire

            \Stripe\Charge::create([
                'amount' => $amount * 100, // Le montant doit être en cents
                'currency' => 'usd', // La devise peut être changée si nécessaire
                'description' => 'Paiement Stripe',
                'source' => $token,
            ]);

            $this->addFlash('success', 'Paiement effectué avec succès!');
            return $this->redirectToRoute('searchE');
        } catch (ApiErrorException $e) {
            $this->addFlash('error', 'Une erreur est survenue lors du paiement: ' . $e->getMessage());
            return $this->redirectToRoute('app_stripe', ['prixtotal' => $amount]); // Rediriger vers la page de paiement avec le montant
        }
    }
}
