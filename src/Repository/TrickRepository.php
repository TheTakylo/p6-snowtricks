<?php

namespace App\Repository;

use App\Entity\Trick;
use App\Entity\TrickCategory;
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

    /**
     * @param int $maxResult
     * @param int|null $offset
     * @return int|mixed|string
     */
    public function findForHomePage(int $maxResult = 15, $offset = null)
    {
        $queryBuiler = $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults($maxResult);

        if ($offset !== null) {
            $queryBuiler->setFirstResult($maxResult * $offset);
        }

        return $queryBuiler->getQuery()
            ->getResult();
    }

    public function findOneBySlugAndCategorySlug(string $trickSlug, string $categorySlug)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.trickCategory', 'tg')
            ->where('t.slug = :trick_slug')->setParameter('trick_slug', $trickSlug)
            ->andWhere('tg.slug = :category_slug')->setParameter('category_slug', $categorySlug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findList(?TrickCategory $trickCategory)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC');

        if ($trickCategory) {
            $queryBuilder->andWhere('t.trickCategory = :trick_category')->setParameter('trick_category', $trickCategory);
        }

        return $queryBuilder->getQuery()
            ->getResult();
    }
}
