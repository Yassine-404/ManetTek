<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class LoginController  extends AbstractController
{


    #[Route('/login', name: 'app_login')]
    public function loginCheckUser(UtilisateurRepository $utilisateurRepository, Request $request, UserPasswordHasherInterface $passwordEncoder, AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $email = $request->request->get('email'); // Make sure the form field and this name match
        $password = $request->request->get('password');

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user && $passwordEncoder->isPasswordValid($user, $password)) {
            // Login success, redirect to the desired route
            return $this->render('admin/index.html.twig', [
                'utilisateurs' => $utilisateurRepository->findAll(),
                'user_id' => $user->getId(),
            ]);
        } else {
            // Login failed, redirect back to the login page or show an error
            $error = 'Invalid credentials. Please try again.';
            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]);
        }
    }


    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }


    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {
                // Generate a unique token for resetting the password
                $token = bin2hex(random_bytes(32));

                // Set the reset token and its expiration date on the user entity
                $user->setResetToken($token);
                $user->setResetTokenExpiresAt(new \DateTime('+1 hour')); // Token expires in 1 hour

                // Persist and flush the changes to the database
                $entityManager->persist($user);
                $entityManager->flush();

                // Generate the password reset link with the token
                $resetLink = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                // Prepare and send the email
                $email = (new Email())
                    ->from('medslama.1945@gmail.com')
                    ->to($user->getEmail())
                    ->subject('Your Password Reset Request')
                    ->html("To reset your password, please click the following link: <a href='$resetLink'>Reset Password</a>");

                $mailer->send($email);

                // Add a flash message and redirect the user
                $this->addFlash('success', 'A reset link has been sent to your email address.');
                return $this->redirectToRoute('app_login');
            } else {
                // Optionally, for security reasons, you might want to always show a success message
                // even if the email is not found, to prevent email enumeration attacks
                $this->addFlash('success', 'If an account exists with the email provided, a reset link has been sent.');
                return $this->redirectToRoute('app_login');
            }
        }

        // Render the "forgot password" form if the method is not POST
        return $this->render('security/forgot_password.html.twig');
    }


    #[Route('/reset-password/{token}', name: 'app_reset_password')]
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, $token): Response
    {
        // Find the user by the reset token
        $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        // Check if the token is valid and not expired
        if (!$user || !$user->getResetTokenExpiresAt() || $user->getResetTokenExpiresAt() <= new \DateTime()) {
            $this->addFlash('danger', 'The password reset token is invalid or has expired.');
            return $this->redirectToRoute('app_forgot_password');
        }

        // Process the form on POST
        if ($request->isMethod('POST')) {
            $newPassword = $request->request->get('password');

            // Validate the new password as needed (e.g., length, complexity)

            // Encode and set the new password
            $encodedPassword = $passwordEncoder->encodePassword($user, $newPassword);
            $user->setPassword($encodedPassword);

            // Reset the token and expiration date to prevent reuse
            $user->setResetToken(null);
            $user->setResetTokenExpiresAt(null);

            // Save the updated user entity
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect the user with a success message
            $this->addFlash('success', 'Your password has been successfully reset. You can now log in with the new password.');
            return $this->redirectToRoute('app_login');
        }

        // Render the reset password form template
        return $this->render('security/reset_password.html.twig', [
            'token' => $token
        ]);
    }

}
