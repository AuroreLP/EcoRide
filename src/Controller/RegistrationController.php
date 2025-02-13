<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\RegistrationFormType;

class RegistrationController extends AbstractController
{

    #[Route("/register", name: "app_register")]

    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        // Créer et traiter le formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            
            // Hacher le mot de passe de l'utilisateur
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Assigner les rôles depuis le formulaire
            $roles = $form->get('roles')->getData();

            // Vérifier si c'est une chaîne et la transformer en tableau
            if (!is_array($roles)) {
                $roles = [$roles ?? 'ROLE_USER'];
            }

            $user->setRoles($roles);

            // Générer le token de vérification
            $user->generateVerificationToken();

            // Enregistrer l'utilisateur dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Envoyer un email de vérification avec un lien contenant le token
            $email = (new Email())
                ->from('support@ecoride.fr')
                ->to($user->getEmail())
                ->subject('Email de vérification')
                ->text('Veuillez cliquer sur ce lien pour vérifier votre email: /verify-email?token=' . $user->getVerificationToken());

            $mailer->send($email);

            // Message de confirmation après l'inscription
            $this->addFlash('success', 'Inscription réussie ! Un email de vérification a été envoyé.');

            // Rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        // Afficher le formulaire d'inscription
        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
