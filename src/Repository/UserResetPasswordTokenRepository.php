<?php

namespace App\Repository;

use App\Entity\UserResetPasswordToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserResetPasswordToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserResetPasswordToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserResetPasswordToken[]    findAll()
 * @method UserResetPasswordToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserResetPasswordTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserResetPasswordToken::class);
    }

    // /**
    //  * @return UserResetPasswordToken[] Returns an array of UserResetPasswordToken objects
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
    public function findOneBySomeField($value): ?UserResetPasswordToken
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
