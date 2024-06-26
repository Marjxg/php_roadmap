<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Client;
use App\Entity\Subsidiary;
use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 *
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    private $emi;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $emi)
    {
        parent::__construct($registry, Transaction::class);
        $this->emi = $emi;
    }

    public function Depositar(Account $account, Transaction $transaction, $sucursal){
        $this->emi->getConnection()->beginTransaction();
        try {
            $account->setBalance($account->getBalance() + $transaction->getAmount());
            $this->emi->persist($account);
            $transaction->setAccount($account);
            //$transaction->setType('Deposito');
            //$transaction->setAmount($monto);
            $transaction->setTransactionDate(new \DateTime());
            $transaction->setSubsidiary($sucursal);
            $this->emi->persist($transaction);

            $this->emi->flush();
            $this->emi->getConnection()->commit();
        } catch (\Exception $e) {
            $this->emi->getConnection()->rollBack();
            throw $e;
        }
    }

    public function Retirar(Account $account, Transaction $transaction, $sucursal)
    {
        $this->emi->getConnection()->beginTransaction();
        try {
            if ($account->getBalance() < $transaction->getAmount()) {
                throw new \Exception('Saldo insuficiente');
            }

            $account->setBalance($account->getBalance() - $transaction->getAmount());
            $this->emi->persist($account);

            $transaction->setAccount($account);
            //$transaction->setType('Retiro');
            //$transaction->setAmount($transaction->getAmount());
            $transaction->setTransactionDate(new \DateTime());
            $transaction->setSubsidiary($sucursal);
            $this->emi->persist($transaction);

            $this->emi->flush();
            $this->emi->getConnection()->commit();
        } catch (\Exception $e) {
            $this->emi->getConnection()->rollBack();
            throw $e;
        }
    }

//    /**
//     * @return Transaction[] Returns an array of Transaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Transaction
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
