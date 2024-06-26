<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\Subsidiary;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi){
        $this->emi = $emi;
    }

    /*#[Route('/login', name: 'user_login')]
    public function user_login(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $login_form = $this->createForm(UserType::class, $user);
        $login_form->handleRequest($request);
        if( $login_form->isSubmitted() && $login_form->isValid() ) {
            $plaintextPassword = $login_form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user = $this->emi->getRepository(User::class)->findOneBy(['username'=>$user->getUsername(), 'password'=>$hashedPassword]);
            if( $user == null ) {
                $this->addFlash('success','Usuario y/o contraseña incorrectos');
                return $this->redirectToRoute('user_login');
            }
            $this->addFlash('success', 'Inicio de sesión correcto!');
        }
        return $this->render('user/index.html.twig', [
            'form' => $login_form->createView(),
        ]);
    }*/

    #[Route('/registry', name: 'user_registry')]
    public function user_registry(UserPasswordHasherInterface $passwordHasher): Response
    {
        $plaintextPassword = "123";
        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setName("Marjorie");
        $user->setLastName("Reyes");
        $user->setUsername("m_reyes");
        $user->setPassword($hashedPassword);
        $user->setRole($this->emi->getRepository(Role::class)->findOneBy(['id'=>1]));
        $user->setSubsidiary($this->emi->getRepository(Subsidiary::class)->findOneBy(['id'=>1]));
        $this->emi->persist($user);
        $this->emi->flush();
        return new JsonResponse(['success'=>true]);
    }
}