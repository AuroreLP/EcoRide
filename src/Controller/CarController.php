<?php

// src/Controller/CarController.php
namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CarController extends AbstractController
{

     #[Route("car/add", name:"car.add")]
    public function addCar(Request $request, UserInterface $user)
    {
        // Vérifie si l'utilisateur a un rôle de conducteur
        if (!in_array('ROLE_DRIVER', $user->getRoles())) {
            return $this->redirectToRoute('home'); // redirection si ce n'est pas un conducteur
        }

        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $car->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            $this->addFlash('success', 'Votre voiture a été ajoutée avec succès.');

            return $this->redirectToRoute('home');
        }

        return $this->render('car/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
