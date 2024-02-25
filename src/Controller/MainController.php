<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Projectweb;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;


class MainController extends AbstractController
{
    #[Route('/app_main', name: 'app_main')]
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


        if (!empty($keyword)) {
            $data = $projectwebRepository->findByKeyword($keyword);
        } else {
            $data = $projectwebRepository->findAll();
        }
        $noResults = empty($data);


        return $this->render('main/store.html.twig', [
            'list' => $data,
            'controller_name' => 'MainController',
            'noResults' => empty($data),
            'keyword' => $keyword ?? '',
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
        $categorieName = 'PS';
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['Type' => $categorieName]);

        if (!$categorie) {
            throw $this->createNotFoundException('Category PS not found.');
        }


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
        $categorieName = 'Xbox';
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['Type' => $categorieName]);

        if (!$categorie) {
            throw $this->createNotFoundException('Category Xbox not found.');
        }

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

        #[Route('/search-prixp', name: 'search_prixp')]
     public function searchPrixp(Request $request, EntityManagerInterface $entityManager): Response
    {
        $minPrice = $request->query->get('minPrice', 0);
        $maxPrice = $request->query->get('maxPrice', 0);

        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $data = $projectwebRepository->findByPriceRange($minPrice, $maxPrice);

        return $this->render('main/store.html.twig', [
            'list' => $data,
            'noResults' => empty($data), //
            'controller_name' => 'ProjectwebController',
        ]);
    }
    #[Route('/add-to-cart/{id}', name: 'add_to_cart')]
    public function addToCart($id, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get('cart', []);
        $quantityToAdd = 1;


        if (isset($cart[$id])) {
            $quantityToAdd = $cart[$id] + 1;
        }


        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $projectweb = $projectwebRepository->find($id);

        if ($projectweb && $projectweb->getStockP() >= $quantityToAdd) {
            $cart[$id] = $quantityToAdd;
            $session->set('cart', $cart);
            $this->addFlash('success', 'Item added to cart successfully.');
        } else {
            $this->addFlash('error', 'Failed to add item to cart. Not enough stock.');
        }

        return $this->redirectToRoute('cart');
    }

    #[Route('/remove-from-cart/{id}', name: 'remove_from_cart')]
    public function removeFromCart($id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);


        unset($cart[$id]);

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }
    #[Route('/update-cart-item/{id}', name: 'update_cart_item', methods: ['POST'])]
    public function updateCartItem($id, Request $request, SessionInterface $session, EntityManagerInterface $entityManager): JsonResponse
    {
        $quantity = $request->request->get('quantity');
        $cart = $session->get('cart', []);
        $cart[$id] = $quantity;
        $session->set('cart', $cart);


        $product = $entityManager->getRepository(Projectweb::class)->find($id);
        $total = $product ? $product->getPrixP() * $quantity : 0;

        return new JsonResponse(['total' => $total]);
    }

    #[Route('/cart', name: 'cart')]
    public function cart(SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $cart = $session->get('cart', []);


        $projectwebRepository = $entityManager->getRepository(Projectweb::class);
        $cartItems = [];

        foreach ($cart as $id => $quantity) {
            $projectweb = $projectwebRepository->find($id);

            if ($projectweb) {
                $cartItems[] = [
                    'projectweb' => $projectweb,
                    'quantity' => $quantity,
                    'total' => $projectweb->getPrixP() * $quantity,

                ];
            }
        }

        return $this->render('cart/cart.html.twig', [
            'cartItems' => $cartItems,
        ]);
    }

    #[Route('/rate-projectweb/{id}', name: 'rate_projectweb')]
    public function rateProjectweb(Projectweb $projectweb, Request $request, EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $submittedToken = $request->request->get('_token');

        if (!$csrfTokenManager->isTokenValid(new CsrfToken('token_id', $submittedToken))) {
            throw new \Exception('Invalid CSRF token');
        }

        $rating = $request->request->get('rating');

        if (!is_numeric($rating) || $rating < 1 || $rating > 5) {

            return $this->redirectToRoute('previous_route_name');
        }

        $projectweb->setTotalRating($projectweb->getTotalRating() + 1);
        $projectweb->setAverageRating(
            ($projectweb->getAverageRating() * ($projectweb->getTotalRating() - 1) + $rating) / $projectweb->getTotalRating()
        );

        $entityManager->flush();


        return $this->redirectToRoute('product_details', ['id' => $projectweb->getId()]);
    }










}
