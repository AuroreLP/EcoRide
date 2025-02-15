<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Security\EmailVerifier;
use App\Entity\User;
use App\Form\RegistrationFormType;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route("/register", name: "app_register")]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        EmailVerifier $emailVerifier) {

        $user = new User();

        // Création et traitement du formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Hacher le mot de passe
                $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);

                // Assigner les rôles depuis le formulaire
                $roles = $form->get('roles')->getData();
                if (!is_array($roles)) {
                    $roles = [$roles ?? 'ROLE_USER'];
                }
                $user->setRoles($roles);

                // Enregistrer l'utilisateur dans la base de données
                $entityManager->persist($user);
                $entityManager->flush();

                // Envoyer l'email de vérification avec EmailVerifier
                $this->emailVerifier->sendEmailConfirmation(
                    'app_verify_email', 
                    $user, 
                    (new TemplatedEmail())
                        ->from(new Address('support@ecoride.fr', 'EcoRide'))
                        ->to($user->getEmail())
                        ->subject('Veuillez confirmer votre email')
                        ->htmlTemplate('registration/confirmation_email.html.twig')
                );

                $this->addFlash('success', 'Inscription réussie ! Un email de vérification a été envoyé.');

                return $this->redirectToRoute('app_login');
            } catch (\Exception $e) {
                $this->addFlash('danger', "Erreur : " . $e->getMessage());
            }
            
        }

        // Afficher le formulaire d'inscription
        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
