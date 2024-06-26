<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Client;
use App\Entity\Subsidiary;
use App\Entity\Transaction;
use App\Form\ClientType;
use App\Form\CreateTransactionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi)
    {
        $this->emi = $emi;
    }

    #[Route('/client/transaction', name: 'app_client_transaction')]
    public function client_transaction(Request $request): Response
    {
        $msg = "";
        $client = new Client();
        $client_form = $this->createForm(ClientType::class, $client);
        $client_form->handleRequest($request);
        if ($client_form->isSubmitted() && $client_form->isValid()) {
            $client = $this->emi->getRepository(Client::class)->findOneBy(['doc_num' => $client->getDocNum(), 'docType' => $client->getDocType()->getId()]);
            if ($client) {
                return $this->redirectToRoute('app_transaction', ['id' => $client->getId()]);
            }
            $msg = 'No se encontró la cuenta';
        }
        return $this->render('find_client/index.html.twig', [
            'client_form' => $client_form->createView(),
            'client' => $client,
            'urls' => ['app_home' => 'Regresar'],
            'msg' => $msg,
        ]);
    }

    #[Route('/transaction/{id}', name: 'app_transaction')]
    public function index(Request $request, $id): Response
    {
        $msg = "";
        $transaction = new Transaction();
        $form = $this->createForm(CreateTransactionType::class, $transaction);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $accountId = $form->get('account_id')->getData();
            $account = $this->emi->getRepository(Account::class)->findOneBy(['id' => $accountId, 'client' => $id]);
            $sucursal = $this->emi->getRepository(Subsidiary::class)->findOneBy(['id'=> $this->getUser()->getSubsidiary()]);
            if ($account) {
                if ($transaction->getType() == 'D') {
                    $this->emi->getRepository(Transaction::class)->Depositar($account, $transaction, $sucursal);
                } else if ($transaction->getType() == 'R') {
                    $this->emi->getRepository(Transaction::class)->Retirar($account, $transaction, $sucursal);
                }
                $msg = 'Transacción completada';
            }
            $msg = 'Número de cuenta no encontrado';
        }
        return $this->render('transaction/index.html.twig', [
            'form' => $form->createView(),
            'urls' => ['app_home' => 'Regresar'],
            'msg' => $msg,
        ]);
    }
}
