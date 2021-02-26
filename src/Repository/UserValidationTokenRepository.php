<?php

namespace App\Repository;

use App\Entity\UserValidationToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserValidationToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserValidationToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserValidationToken[]    findAll()
 * @method UserValidationToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserValidationTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserValidationToken::class);
    }

    // /**
    //  * @return UserValidationToken[] Returns an array of UserValidationToken objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserValidationToken
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
