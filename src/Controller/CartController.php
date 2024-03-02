<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Jeux;
use App\Entity\Projectweb;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/add-to-cart/{id}', name: 'add_to_cart')]
    public function addToCart($id, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get('cart', []);
        $quantityToAdd = 1;

        if (isset($cart[$id])) {
            $quantityToAdd = $cart[$id] + 1;
        }

        $product = $entityManager->getRepository(Projectweb::class)->find($id);

        if ($product && $product->getStockP() >= $quantityToAdd) {

            $existingCartItem = $entityManager->getRepository(Cart::class)->findOneBy([
                'entityType' => 'Projectweb',
                'entityId' => $id,
            ]);

            if ($existingCartItem) {

                $existingCartItem->setQuantity($quantityToAdd);
            } else {

                $cartItem = new Cart();
                $cartItem->setEntityType('Projectweb');
                $cartItem->setEntityId($id);
                $cartItem->setQuantity($quantityToAdd);
                $cartItem->setCreatedAt(new \DateTimeImmutable());

                $entityManager->persist($cartItem);
            }


            $cart[$id] = $quantityToAdd;
            $session->set('cart', $cart);

            $entityManager->flush();

            $this->addFlash('success', 'Item added to cart successfully.');
        } else {
            $this->addFlash('error', 'Failed to add item to cart. Not enough stock.');
        }

        return $this->redirectToRoute('cart');
    }

    #[Route('/add-to-cart-jeux/{id}', name: 'add_to_cart_jeux')]
    public function addJeuxToCart($id, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get('cart_jeux', []);
        $quantityToAdd = 1;

        if (isset($cart[$id])) {
            $quantityToAdd = $cart[$id] + 1;
        }

        $jeux = $entityManager->getRepository(Jeux::class)->find($id);

        if ($jeux && $jeux->getStockj() >= $quantityToAdd) {

            $cartRepository = $entityManager->getRepository(Cart::class);
            $cartItem = $cartRepository->findOneBy([
                'entityType' => 'Jeux',
                'entityId' => $id,
            ]);

            if ($cartItem) {

                $cartItem->setQuantity($quantityToAdd);
            } else {

                $cartItem = new Cart();
                $cartItem->setEntityType('Jeux');
                $cartItem->setEntityId($id);
                $cartItem->setQuantity($quantityToAdd);
                $cartItem->setCreatedAt(new \DateTimeImmutable());
                $entityManager->persist($cartItem);
            }

            $cart[$id] = $quantityToAdd;
            $session->set('cart_jeux', $cart);

            $entityManager->flush();

            $this->addFlash('success', 'Item added to cart successfully.');
        } else {
            $this->addFlash('error', 'Failed to add item to cart. Not enough stock.');
        }

        return $this->redirectToRoute('cart_jeux');
    }



    #[Route('/remove-from-cart/{id}', name: 'remove_from_cart')]
    public function removeFromCart($id, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get('cart', []);


        unset($cart[$id]);
        $session->set('cart', $cart);


        $cartRepository = $entityManager->getRepository(Cart::class);
        $cartItem = $cartRepository->findOneBy(['entityId' => $id]);
        if ($cartItem) {
            $entityManager->remove($cartItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cart');
    }
    #[Route('/remove-from-cart-jeux/{id}', name: 'remove_from_cart_jeux')]
    public function removeFromCartJeux($id, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get('cart_jeux', []);

        unset($cart[$id]);

        $session->set('cart_jeux', $cart);

        $cartRepository = $entityManager->getRepository(Cart::class);
        $cartItem = $cartRepository->findOneBy([
            'entityType' => 'Jeux',
            'entityId' => $id,
        ]);

        if ($cartItem) {
            $entityManager->remove($cartItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cart_jeux');
    }

    #[Route('/update-cart-item/{id}', name: 'update_cart_item', methods: ['POST'])]
    public function updateCartItem($id, Request $request, SessionInterface $session, EntityManagerInterface $entityManager): JsonResponse
    {
        $quantity = $request->request->get('quantity');
        $cart = $session->get('cart', []);
        $cart[$id] = $quantity;
        $session->set('cart', $cart);

        $product = $entityManager->getRepository(Cart::class)->find($id);
        $total = $product ? $product->getPrixP() * $quantity : 0;

        return new JsonResponse(['total' => $total]);
    }


}
