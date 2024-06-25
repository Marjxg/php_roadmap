<?php

namespace App\Repository;

use App\Entity\DocType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocType>
 *
 * @method DocType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocType[]    findAll()
 * @method DocType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocType::class);
    }

//    /**
//     * @return DocType[] Returns an array of DocType objects
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

//    public function findOneBySomeField($value): ?DocType
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
