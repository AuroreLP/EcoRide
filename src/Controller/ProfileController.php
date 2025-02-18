<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{

    #[Route('/profile', name: 'profile.index')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('profile/index.html.twig', [
            'users' => $userRepository->findAll(),
            'controller_name' => 'ProfileController'
        ]);
    }


    #[Route('/profile/{id}', name: 'profile.show')]
    public function show(User $user): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $user,
            'controller_name' => 'ProfileController'
        ]);
    }

    #[Route('/profile/edit/{id}', name: 'profile.edit')]
    public function edit(Request $request, EntityManagerInterface $em, int $id): Response
    {
        // récupérer l'utilisateur par ID
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException("L'utilisateur n'existe pas");
        }

        // créer et gérer le formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $photoFile = $form->get('photo')->getData();

            if($photoFile) {
                $newFilename = uniqid().'.'.$photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // gérer l'erreur si le fichier n'a pas pu être déplacé
                }

                // mettre à jour le champ photo dans l'entité
                $user->setPhoto($newFilename);
            }

            $em->flush();

            return $this->redirectToRoute('profile/{id}', ['id' => $user->getId()]);
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
