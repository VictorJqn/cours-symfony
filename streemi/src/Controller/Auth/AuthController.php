<?php

namespace App\Controller\Auth;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthController extends AbstractController
{
    #[Route(path: '/forgot', name: 'page_forgot_password', methods: ['POST'])]
public function forgotPassword(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
{
    $email = $request->get('email');

    // Chercher l'utilisateur par email
    $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

    if (!$user) {
        // Utilisation de addFlash pour envoyer un message d'erreur
        $this->addFlash('error', 'Aucun utilisateur trouvé avec cet email.');
        return $this->redirectToRoute('page_forgot_password'); // redirige vers la même page pour afficher l'erreur
    }

    // Générer un resetToken
    $resetToken = Uuid::v4()->toRfc4122();
    $user->setResetToken($resetToken);
    $user->setResetTokenExpireAt(new \DateTimeImmutable('+1 hour'));

    // Sauvegarder l'utilisateur avec le token
    $entityManager->flush();

    // Créer un email à l'aide de TemplatedEmail
    $resetUrl = $this->generateUrl('page_reset_password', ['token' => $resetToken], 0); // Génère l'URL pour la réinitialisation

    $emailMessage = (new TemplatedEmail())
        ->from('no-reply@votre-domaine.com')
        ->to($user->getEmail())
        ->subject('Réinitialisation de votre mot de passe')
        ->htmlTemplate('email/reset.html.twig')  // Utiliser le template Twig
        ->context([
            'resetToken' => $resetToken,
            'resetUrl' => $resetUrl, // Passer l'URL au template
            'email' => $user->getEmail(),
        ]);

    $mailer->send($emailMessage);

    $this->addFlash('success', 'Un email de réinitialisation de mot de passe vous a été envoyé.');

    return $this->redirectToRoute('page_forgot_password');  
}

    #[Route(path: '/forgot', name: 'page_forgot_password')]
public function forgotPasswordPage(): Response
{
    return $this->render('auth/forgot.html.twig');
}

#[Route(path: '/reset/{token}', name: 'page_reset_password')]
public function resetPassword(
    string $token,
    Request $request,
    EntityManagerInterface $entityManager,
    UserPasswordHasherInterface $passwordHasher
): Response {
    // Chercher l'utilisateur avec le resetToken
    $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

    if (!$user || $user->getResetTokenExpireAt() < new \DateTimeImmutable()) {
        // Si l'utilisateur n'existe pas ou si le token a expiré
        $this->addFlash('error', 'Token invalide ou expiré.');
        return $this->redirectToRoute('page_forgot_password');
    }

    // Si la méthode de la requête est GET, afficher la page avec le formulaire
    if ($request->isMethod('GET')) {
        return $this->render('auth/reset.html.twig', [
            'token' => $token
        ]);
    }

    // Si la méthode de la requête est POST, traiter le formulaire
    if ($request->isMethod('POST')) {
        $password = $request->request->get('password');
        $confirmPassword = $request->request->get('confirm_password');

        // Vérifier si les mots de passe correspondent
        if ($password !== $confirmPassword) {
            $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
            return $this->render('auth/reset.html.twig', [
                'token' => $token
            ]);
        }

        // Hasher le mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $password);

        // Mettre à jour le mot de passe de l'utilisateur
        $user->setPassword($hashedPassword);
        $user->setResetToken(null);  // Invalider le token après réinitialisation

        // Sauvegarder l'utilisateur avec le nouveau mot de passe
        $entityManager->flush();

        // Ajouter un message de succès
        $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');

        // Rediriger l'utilisateur vers la page de connexion
        return $this->redirectToRoute('app_login');
    }

    // Si la méthode n'est pas GET ou POST (cas par défaut)
    return $this->redirectToRoute('page_forgot_password');
}

    #[Route(path: '/confirm', name: 'page_confirm_email')]
    public function confirmEmail(): Response
    {
        return $this->render(view: 'auth/confirm.html.twig');
    }
}
