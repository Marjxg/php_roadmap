<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultAccountController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi){
        $this->emi = $emi;
    }

    #[Route('/consult/account', name: 'app_consult_account')]
    public function index(Request $request): Response
    {
        $accounts = [];
        $client = new Client();
        $client_form = $this->createForm(ClientType::class, $client);
        $client_form->handleRequest($request);
        if ($client_form->isSubmitted() && $client_form->isValid()) {
            $client = $this->emi->getRepository(Client::class)->findOneBy(['doc_num'=>$client->getDocNum(), 'docType'=>$client->getDocType()->getId()]);
            if ($client){
                $accounts = $this->emi->getRepository(Account::class)->findBy(['client' => $client->getId()]);
            }
        }
        return $this->render('consult_account/index.html.twig', [
            'client_form' => $client_form->createView(),
            'client' => $client,
            'cuentas'=> $accounts,
            'urls' => ['app_home' => 'Regresar'],
        ]);
    }
}
