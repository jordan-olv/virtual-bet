<?php

namespace App\Repository;

use App\Entity\UserEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEvenement>
 *
 * @method UserEvenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEvenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEvenement[]    findAll()
 * @method UserEvenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEvenement::class);
    }

//    /**
//     * @return UserEvenement[] Returns an array of UserEvenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserEvenement
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
