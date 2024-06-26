<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Client;
use App\Form\AccountType;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateAccountController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi){
        $this->emi = $emi;
    }

    #[Route('/find/client', name: 'app_find_client')]
    public function find_client(Request $request): Response
    {
        $msg = "";
        $client = new Client();
        $client_form = $this->createForm(ClientType::class, $client);
        $client_form->handleRequest($request);
        if ($client_form->isSubmitted() && $client_form->isValid()) {
            $client = $this->emi->getRepository(Client::class)->findOneBy(['doc_num'=>$client->getDocNum(), 'docType'=>$client->getDocType()->getId()]);
            if ($client){
                return $this->redirectToRoute('app_create_account', ['id'=> $client->getId()]);
            }
            $msg = 'Cliente no encontrado';
        }
        return $this->render('find_client/index.html.twig', [
            'client_form' => $client_form->createView(),
            'client' => $client,
            'urls' => ['app_home' => 'Regresar'],
            'msg'=> $msg,
        ]);
    }

    #[Route('/create/account/{id}', name: 'app_create_account')]
    public function create_account(Request $request, $id): Response
    {
        $msg = "";
        $client = $this->emi->getRepository(Client::class)->findOneBy(['id'=>$id]);
        $account = new Account();
        $account_form = $this->createForm(AccountType::class, $account);
        $account_form->handleRequest($request);
        if ($account_form->isSubmitted() && $account_form->isValid()){
            $account->setClient($client);
            $account->setCreationDate(new \DateTime());
            $this->emi->persist($account);
            $this->emi->flush();
            $msg = 'Cuenta de ahorros creada!';
        }
        return $this->render('create_account/index.html.twig', [
            'client' => $client,
            'form' => $account_form->createView(),
            'urls' => ['app_home' => 'Regresar'],
            'msg'=> $msg,
        ]);
    }
}
