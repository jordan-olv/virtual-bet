<?php

namespace App\Repository;

use App\Entity\MonstreDex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MonstreDex>
 *
 * @method MonstreDex|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonstreDex|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonstreDex[]    findAll()
 * @method MonstreDex[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonstreDexRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonstreDex::class);
    }

//    /**
//     * @return MonstreDex[] Returns an array of MonstreDex objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MonstreDex
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
