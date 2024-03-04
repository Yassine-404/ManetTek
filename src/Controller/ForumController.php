<?php

namespace App\Controller;

use App\Form\CommentaireType;
use App\Form\SujetType;
use App\Entity\Signalement;

use App\Entity\Sujet;
use App\Entity\User;
use App\Entity\Commentaire;
use App\Service\EmailService;
use App\Repository\SujetRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ForumController extends AbstractController
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
    #[Route('/forum', name: 'app_forum')]
    public function index(): Response
    {
        $sujets = $this->getDoctrine()->getRepository(Sujet::class)->findAll();

        return $this->render('forum/index.html.twig', [
            'sujets' => $sujets,
        ]);
    }

    #[Route('/forum/search', name: 'search', methods: ['GET'])]
    public function search(Request $request): Response
    {
        $query = $request->query->get('q');

        // Récupérer les sujets qui correspondent à la recherche
        $sujets = $this->getDoctrine()->getRepository(Sujet::class)
            ->createQueryBuilder('s')
            ->where('s.titre LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        return $this->render('forum/search_results.html.twig', [
            'sujets' => $sujets,
            'query' => $query,
        ]);
    }

    #[Route('/forum/ajouter-sujet', name: 'ajouter_sujet')]
    public function ajouterSujet(Request $request): Response
    {
        // Créer une nouvelle instance de Sujet
        $sujet = new Sujet();

        // Définir la valeur par défaut de 'actif' à 0
        $sujet->setActif(1);

        // Créer le formulaire pour le sujet
        $form = $this->createForm(SujetType::class, $sujet);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur actuel et l'associer au sujet comme auteur
            $utilisateur = $this->getDoctrine()->getRepository(User::class)->find(2);
            $sujet->setAuteur($utilisateur);

            // Enregistrer le sujet en base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sujet);
            $entityManager->flush();

            $users = $this->getDoctrine()->getRepository(User::class)->findAll();
            foreach ($users as $user) {
                $recipient = $user->getEmail();
                $subject = 'Nouveau sujet ajouté sur le forum';
                $content = 'Un nouveau sujet a été ajouté sur notre forum. Venez le découvrir !';

                // Envoyer l'e-mail
                $this->emailService->sendEmail($recipient, $subject, $content);
            }

            // Rediriger vers une autre page (par exemple, la liste des sujets)
            return $this->redirectToRoute('afficher_sujet', ['id' => $sujet->getId()]);
        }

        // Si le formulaire n'est pas soumis ou n'est pas valide, afficher à nouveau la page avec le formulaire
        return $this->render('forum/ajouter_sujet.html.twig', [
            'form' => $form->createView(), // Assurez-vous que la variable 'form' est toujours définie
        ]);
    }

    #[Route('/forum/sujet/{id}', name: 'afficher_sujet')]
public function afficherSujet(Request $request, $id, SujetRepository $sujetRepository): Response
{
    $sujet = $sujetRepository->find($id);

    // Créer une nouvelle instance de commentaire
    $commentaire = new Commentaire();

    // Créer le formulaire d'ajout de commentaire
    $form = $this->createForm(CommentaireType::class, $commentaire);
    $form->handleRequest($request);

    // Si le formulaire est soumis et valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Associer le commentaire au sujet actuel
        $commentaire->setSujet($sujet);
        // Associer l'utilisateur actuel comme auteur du commentaire
        $commentaire->setAuteur($this->getUser());

        // Enregistrer le commentaire en base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commentaire);
        $entityManager->flush();

        // Rediriger vers la même page pour éviter les soumissions multiples
        return $this->redirectToRoute('afficher_sujet', ['id' => $id]);
    }

    return $this->render('forum/afficher_sujet.html.twig', [
        'sujet' => $sujet,
        'form' => $form->createView(),
    ]);
}



#[Route('/forum/sujet/{id}/ajouter-commentaire', name: 'ajouter_commentaire')]
public function ajouterCommentaire(Request $request, $id): Response
{
    // Récupérer le sujet associé à l'ID
    $sujet = $this->getDoctrine()->getRepository(Sujet::class)->find($id);

    // Créer une nouvelle instance de Commentaire
    $commentaire = new Commentaire();

    // Créer le formulaire pour le commentaire
    $form = $this->createForm(CommentaireType::class, $commentaire);
    

    $form->handleRequest($request);

    // Si le formulaire est soumis et valide
    if ($form->isSubmitted() && $form->isValid()) {
        // Associer le commentaire au sujet
        $commentaire->setSujet($sujet);
        
        // Associer l'utilisateur ayant l'ID 1 comme auteur du commentaire
        $utilisateur = $this->getDoctrine()->getRepository(User::class)->find(1);
        $commentaire->setAuteur($utilisateur);

        // Persister le commentaire
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commentaire);
        $entityManager->flush();

        // Rediriger vers la page d'affichage du sujet
        return $this->redirectToRoute('afficher_sujet', ['id' => $id]);
    }

    // Si le formulaire n'est pas soumis ou n'est pas valide, afficher à nouveau la page avec le formulaire
    
    return $this->render('forum/afficher_sujet.html.twig', [
        'sujet' => $sujet,
        'form' => $form->createView(), // Assurez-vous que la variable 'form' est toujours définie
    ]);
    
}
    #[Route('/forum/sujet/{sujetId}/commentaire/{id}/like', name: 'like_commentaire')]
    public function likeCommentaire(int $sujetId, int $id): RedirectResponse
    {
        // Récupérez le commentaire correspondant à l'ID
        $commentaire = $this->getDoctrine()->getRepository(Commentaire::class)->find($id);

        if (!$commentaire) {
            throw $this->createNotFoundException('Commentaire non trouvé avec l\'identifiant '.$id);
        }

        $user = $this->getDoctrine()->getRepository(User::class)->find(1);
        $utilisateurId = $user->getId();

        // Vérifiez si l'utilisateur a déjà liké ce commentaire
        if (in_array($utilisateurId, $commentaire->getLikes(), true)) {
            // L'utilisateur a déjà liké ce commentaire, vous pouvez choisir de le rediriger ou d'afficher un message d'erreur
            // Ici, je choisis de rediriger vers la page précédente
            return $this->redirectToRoute('afficher_sujet', ['id' => $sujetId]);
        }

        // Ajoutez l'ID de l'utilisateur à la liste des likes du commentaire
        $likes = $commentaire->getLikes();
        $likes[] = $utilisateurId;
        $commentaire->setLikes($likes);

        // Incrémentez le nombre de likes du commentaire
        $commentaire->setNombreLikes($commentaire->getNombreLikes() + 1);

        // Enregistrez les modifications dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        // Redirigez l'utilisateur vers la page précédente ou une autre page
        return $this->redirectToRoute('afficher_sujet', ['id' => $sujetId]);
    }


    #[Route('/forum/signaler/{id}', name: 'app_forum_signaler_sujet', methods: ['GET'])]
    public function signalerSujet(Sujet $sujet): Response
    {
        // Récupérer l'utilisateur actuel (si nécessaire)
        $user = $this->getDoctrine()->getRepository(User::class)->find(1);
        $utilisateur = $user->getId();

        // Créer un nouveau signalement
        $signalement = new Signalement();
        $signalement->setSujet($sujet);
        $signalement->setAuteur($utilisateur); // Ou définir l'auteur du signalement selon votre logique
        $signalement->setDate(new \DateTime());

        // Enregistrer le signalement dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($signalement);
        $entityManager->flush();

        // Rediriger l'utilisateur vers une page de confirmation ou une autre page appropriée
        return $this->redirectToRoute('app_forum');
    }

}