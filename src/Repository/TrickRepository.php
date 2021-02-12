<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function findForHomePage()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult();
    }

    public function findOneBySlugAndGroupSlug(string $trickSlug, string $groupSlug)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.trickGroup', 'tg')
            ->where('t.slug = :trick_slug')->setParameter('trick_slug', $trickSlug)
            ->andWhere('tg.slug = :group_slug')->setParameter('group_slug', $groupSlug)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
