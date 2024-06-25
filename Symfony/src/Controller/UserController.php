<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $emi;

    public function __construct(EntityManagerInterface $emi){
        $this->emi = $emi;
    }

    #[Route('/registration', name: 'userRegistration')]
    public function userRegistration(Request $request): Response
    {
        $user = new User();
        $registration_form = $this->createForm(UserType::class, $user);
        $registration_form->handleRequest($request);
        if($registration_form->isSubmitted() && $registration_form->isValid()) {
            $this->emi->persist($user);
            $this->emi->flush();
            return $this->redirectToRoute('userRegistration');
        }
        return $this->render('user/index.html.twig', [
            'registration_form' => $registration_form->createView(),
        ]);
    }
}
