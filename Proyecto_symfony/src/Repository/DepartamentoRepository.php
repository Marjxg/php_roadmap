<?php

namespace App\Repository;

use App\Entity\Departamento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departamento>
 *
 * @method Departamento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departamento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departamento[]    findAll()
 * @method Departamento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartamentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departamento::class);
    }

//    /**
//     * @return Departamento[] Returns an array of Departamento objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Departamento
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
